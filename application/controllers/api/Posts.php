<?php
defined('BASEPATH') or die('Direct access not allowed');

class Posts extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_POSTS;
		$this->module = MOD_BLOG;
		$this->model = 'blog';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = 'b.id, b.title_'.DEFAULT_LANGUAGE.' AS title ## category_title_default, featured_text, published_text, created_on';
        $group_by = 'b.id';
        $sql = $this->blog_model->sql(['cat'], $select, [], true);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $group_by);
    }


    private function adit($id = null) {
        $languages = get_site_languages();
        $language_columns = $this->blog_model->language_columns();
        $slug = url_title(strtolower(xpost('title_'.DEFAULT_LANGUAGE)));
        $data = [
            'slug' => $slug, 
            'category_id' => xpost('category_id'),
            'featured_video' => xpost('featured_video') ?: null,
            'published' => xpost('published') ?: 0,
            'featured' => xpost('featured') ?: 0,
        ];

        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|is_natural');
        $this->form_validation->set_rules('published', 'Published', 'trim|is_natural|in_list[0,1]');
        $this->form_validation->set_rules('featured', 'Featured Post', 'trim|is_natural|in_list[0,1]');
        $this->form_validation->set_rules('featured_video', 'Featured Video URL', 'trim|valid_url');
        foreach ($language_columns as $key => $arr) {
            foreach ($languages as $lang) {
                $input_field = $key.'_'.$lang['key'];
                $this->form_validation->set_rules($input_field, $arr['title'], 'trim|required');
                $data[$input_field] = ($arr['input'] == 'textarea') ? xpost_txt($input_field) : ucwords(xpost($input_field));
            }
        }
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        //Slug already exists?
        $slug_exists = $this->common_model->exists($this->table, ['slug' => $slug], $id);
        if ($slug_exists) json_response('A post with this title already exists', false);
        
        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        // $required = (strlen(trim($data['featured_video'])) === 0); //must upload featured image if no video url
        $upload_conf = ['path' => 'uploads/pix/blog', 'ext' => 'png|jpg|jpeg', 'size' => 1024, 'required' => false];
        $file_name = upload_image('featured_image', $upload_conf, false);
        $data['featured_image'] = $file_name;
        if (!$data['featured_image'] && !$data['featured_video']) {
            json_response('Post must have either featured image or video or both', false);
        }
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'posts/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $row = $this->blog_model->get_details($id, 'id', [], 'featured_image');
        $data = $this->adit($id);
        $upload_conf = ['path' => 'uploads/pix/blog', 'ext' => 'png|jpg|jpeg', 'size' => 1024, 'required' => false];
        $file_name = upload_image('featured_image', $upload_conf, true, $row->featured_image);
        $data['featured_image'] = $file_name;
        if (!$data['featured_image'] && !$data['featured_video']) {
            json_response('Post must have either featured image or video or both', false);
        }
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'posts/view/'.$id]);
    }
    
}