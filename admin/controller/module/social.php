<?php
class ControllerModuleSocial extends Controller {
    private $error = array(); // This is used to set the errors, if any.
 
    public function index() {
        // Loading the language file of line
        $this->load->language('module/social');
     
        // Set the title of the page to the heading title in the Language file i.e., Hello World
        $this->document->setTitle($this->language->get('heading_title'));
     
        // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )

        $this->load->model('setting/setting');

        // Start If: Validates and check if data is coming by save (POST) method
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // Parse all the coming data to Setting Model to save it in database.
            $this->model_setting_setting->editSetting('messenger', $this->request->post);
            $this->model_setting_setting->editSetting('line', $this->request->post);
            $this->model_setting_setting->editSetting('wa', $this->request->post);
            $this->model_setting_setting->editSetting('bbm', $this->request->post);
            $this->model_setting_setting->editSetting('sms', $this->request->post);
            $this->model_setting_setting->editSetting('lineid', $this->request->post);

            // To display the success text on data save
            $this->session->data['success'] = $this->language->get('text_success');

            // Redirect to the Module Listing
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        // Assign the language data for parsing it to view
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit']    = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');      
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');

        $data['entry_code_line'] = $this->language->get('entry_code_line');
        $data['entry_code_messenger'] = $this->language->get('entry_code_messenger');
        $data['entry_code_wa'] = $this->language->get('entry_code_wa');
        $data['entry_code_bbm'] = $this->language->get('entry_code_bbm');
        $data['entry_code_sms'] = $this->language->get('entry_code_sms');
        $data['entry_code_lineid'] = $this->language->get('entry_code_lineid');

        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');

        // This Block returns the warning if any
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
     
        // This Block returns the error code if any
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }     
     
        // Making of Breadcrumbs to be displayed on site
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/social', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
          
        $data['action'] = $this->url->link('module/social', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed
     
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed



        // Messenger MODUL     
        // This block checks, if the Messenger text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it
        if (isset($this->request->post['messenger_text_field'])) {
            $data['messenger_text_field'] = $this->request->post['messenger_text_field'];
        } else {
            $data['messenger_text_field'] = $this->config->get('messenger_text_field');
        }
        // This block parses the status (enabled / disabled)
        if (isset($this->request->post['messenger_status'])) {
            $data['messenger_status'] = $this->request->post['messenger_status'];
        } else {
            $data['messenger_status'] = $this->config->get('messenger_status');
        }




        // LINE MODUL
        // This block checks, if the line text field is set it parses it to view otherwise get the default

        // hello world text field from the database and parse it

        if (isset($this->request->post['line_text_field'])) {
            $data['line_text_field'] = $this->request->post['line_text_field'];
        } else {
            $data['line_text_field'] = $this->config->get('line_text_field');
        }
        // This block parses the status (enabled / disabled)

        if (isset($this->request->post['line_status'])) {
            $data['line_status'] = $this->request->post['line_status'];
        } else {
            $data['line_status'] = $this->config->get('line_status');
        }


        // WhatsApp MODUL     
        // This block checks, if the WhatsApp text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it
        if (isset($this->request->post['wa_text_field'])) {
            $data['wa_text_field'] = $this->request->post['wa_text_field'];
        } else {
            $data['wa_text_field'] = $this->config->get('wa_text_field');
        }
        // This block parses the status (enabled / disabled)
        if (isset($this->request->post['wa_status'])) {
            $data['wa_status'] = $this->request->post['wa_status'];
        } else {
            $data['wa_status'] = $this->config->get('wa_status');
        }



        // BBM MODUL
        // This block checks, if the BBM text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it
        if (isset($this->request->post['bbm_text_field'])) {
            $data['bbm_text_field'] = $this->request->post['bbm_text_field'];
        } else {
            $data['bbm_text_field'] = $this->config->get('bbm_text_field');
        }
        // This block parses the status (enabled / disabled)
        if (isset($this->request->post['bbm_status'])) {
            $data['bbm_status'] = $this->request->post['bbm_status'];
        } else {
            $data['bbm_status'] = $this->config->get('bbm_status');
        }


        // SMS MODUL
        // This block checks, if the SMS text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it

        if (isset($this->request->post['sms_text_field'])) {
            $data['sms_text_field'] = $this->request->post['sms_text_field'];
        } else {
            $data['sms_text_field'] = $this->config->get('sms_text_field');
        }
        // This block parses the status (enabled / disabled)
        if (isset($this->request->post['sms_status'])) {
            $data['sms_status'] = $this->request->post['sms_status'];
        } else {
            $data['sms_status'] = $this->config->get('sms_status');
        }



        // LINE ID Modul
        // This block checks, if the Line ID text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it

        if (isset($this->request->post['lineid_text_field'])) {
            $data['lineid_text_field'] = $this->request->post['lineid_text_field'];
        } else {
            $data['lineid_text_field'] = $this->config->get('lineid_text_field');
        }
        // This block parses the status (enabled / disabled)
        if (isset($this->request->post['lineid_status'])) {
            $data['lineid_status'] = $this->request->post['lineid_status'];
        } else {
            $data['lineid_status'] = $this->config->get('lineid_status');
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/social.tpl', $data));

    }

    /* Function that validates the data when Save Button is pressed */
    protected function validate() {
 
        // Block to check the user permission to manipulate the module
        if (!$this->user->hasPermission('modify', 'module/social')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        // Block to check if the social_text_field is properly set to save into database,
        // otherwise the error is returned

        if (($this->request->post['messenger_text_field']) && ($this->request->post['messenger_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['messenger_text_field']) && ($this->request->post['messenger_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['messenger_text_field']) && ($this->request->post['messenger_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }



        if (($this->request->post['line_text_field']) && ($this->request->post['line_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['line_text_field']) && ($this->request->post['line_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['line_text_field']) && ($this->request->post['line_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }



        if (($this->request->post['wa_text_field']) && ($this->request->post['wa_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['wa_text_field']) && ($this->request->post['wa_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['wa_text_field']) && ($this->request->post['wa_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }




        if (($this->request->post['bbm_text_field']) && ($this->request->post['bbm_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['bbm_text_field']) && ($this->request->post['bbm_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['bbm_text_field']) && ($this->request->post['bbm_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }



        if (($this->request->post['sms_text_field']) && ($this->request->post['sms_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['sms_text_field']) && ($this->request->post['sms_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['sms_text_field']) && ($this->request->post['sms_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }
 


        if (($this->request->post['lineid_text_field']) && ($this->request->post['lineid_status'] == 0)){
            !$this->error;
        }
        elseif(($this->request->post['lineid_text_field']) && ($this->request->post['lineid_status'] == 1)){
            !$this->error;
        }
        elseif ((!$this->request->post['lineid_text_field']) && ($this->request->post['lineid_status'] == 0)) {
            !$this->error;
        }
        else{
            $this->error['code'] = $this->language->get('error_code');
        }
 
        // Block returns true if no error is found, else false if any error detected
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}