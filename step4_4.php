<?php include('includes/include.php');
set_time_limit(0); ?>
<?php

//echo sizeof($_POST['frmShow']);
//exit;
//if(sizeof($_POST['frmShow'])==1){
//    echo("
//        <script>
//        alert('Please select at least one field to show for table `".$_POST['frmFormsetvalue']."` formset.');
//        </script>
//    ");
//    exit;
//}
print_array($_POST);
//create admin folder if not exists
if (!is_dir($adminPath)) {
    mkdir($adminPath)
            or die("
	       <script>
	       alert('Destination folder `$adminPath` does not exist.');
	       </script>
	       ");
    if (file_exists('files/access-denied.html')) {
        copy('files/access-denied.html', $adminPath . '/index.html');
    }
}
//make controller
$controllerPath = $adminPath . '/controllers/' . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '.php';
$controllerText = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class " . ucwords($_POST['frmFormsetvalue']) . " extends CI_Controller {
    #INDEX_FUNCTION#
    #ADD_FUNCTION#
    #UPDATE_FUNCTION#
    #DOADD_FUNCTION#
    #DOUPDATE_FUNCTION#
    #DODELETE_FUNCTION#
}";
$indexFunction = "
	public function index()
	{
            //Get manage page
            \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
            \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_manage();
            checkLogin();
            ";
if ($_POST['table'] == 'sulata_settings') {
    $indexFunction.="riExit('Operation not allowed.');
                    ";
}
$indexFunction.="
	    //Get settings
            \$this->load->model('_admin/get_general');
            \$results=\$this->get_general->getSettings();
            //Make page head tags
            foreach(\$results as \$row){
                \$data['site_title'] = riUnstrip(\$row->setting__Site_Title);
                \$data['site_url'] = riUnstrip(\$row->setting__Site_URL);
                \$data['site_email'] = riUnstrip(\$row->setting__Site_Email);
                \$data['site_pagination'] = riUnstrip(\$row->setting__Pagination_Size);
            }
           \$data['search_string']='" . makeFieldLabel($_POST['frmOrderby']) . "';
           \$data['heading']='MANAGE " . strtoupper(str_replace('_', ' ', $_POST['frmFormsetvalue'])) . "';
 
           \$this->load->view('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_manage',\$data);
 

	}
";
$addFunction = "
        public function add()
	{
            checkLogin();
            //Get remote scripting method
            \$remote = \$this->config->item('remote');
            //Get add page
            \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
            \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_add();
	    
            ";
if ($_POST['table'] == 'sulata_settings') {
    $addFunction.="riExit('Operation not allowed.');
                    ";
}
$addFunction.="
            //Get settings
            \$this->load->model('_admin/get_general');
            \$results=\$this->get_general->getSettings();
            //Make page head tags
            foreach(\$results as \$row){
                \$data['site_title'] = riUnstrip(\$row->setting__Site_Title);
                \$data['site_url'] = riUnstrip(\$row->setting__Site_URL);
                \$data['site_email'] = riUnstrip(\$row->setting__Site_Email);
                \$data['site_pagination'] = riUnstrip(\$row->setting__Pagination_Size);
            }
	    ";
//Make dropdowns
$makeDd = "";
for ($i = 0; $i <= sizeof($_POST['frmType']) - 1; $i++) {
    if ($_POST['frmType'][$i] == 'Dropdown from DB') {
        //Get dropdown text
        $tableFieldText = explode(".", $_POST['frmForeignkeytext'][$i]);
        $table = $tableFieldText[0];
        $fieldText = $tableFieldText[1];
        //Get dropdown value
        $tableFieldId = explode(".", $_POST['frmForeignkeyvalue'][$i]);
        $table = $tableFieldId[0];
        $fieldId = $tableFieldId[1];
        $makeDd .= "\$sql = \"SELECT $fieldId AS f1, $fieldText AS f2 FROM $table ORDER BY f2\";
	    \$this->load->model('_admin/get_general');
	    \$data['dd_" . $_POST['frmField'][$i] . "'] = \$this->get_general->riDropdown(\$sql);";
    }
}
$addFunction.="
            //Make dropdown
            //Build SQL from dropdown and alias fields as f1 and f2
	    $makeDd

                        
            //Make heading
           \$data['heading']='ADD " . strtoupper(str_replace('_', ' ', $_POST['frmFormsetvalue'])) . "';
           
           \$this->load->view('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_add',\$data);
	}
";
$updateFunction = "
        public function update()
	{
            checkLogin();
            //Get remote scripting method
            \$remote = \$this->config->item('remote');
            //Get update form
            \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
            \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_update();   
            
            
	    //Get settings
            \$this->load->model('_admin/get_general');
            \$results=\$this->get_general->getSettings();
            //Make page head tags
            foreach(\$results as \$row){
                \$data['site_title'] = riUnstrip(\$row->setting__Site_Title);
                \$data['site_url'] = riUnstrip(\$row->setting__Site_URL);
                \$data['site_email'] = riUnstrip(\$row->setting__Site_Email);
                \$data['site_pagination'] = riUnstrip(\$row->setting__Pagination_Size);
            }
	    ";
//Make dropdowns
$makeDd = "";
for ($i = 0; $i <= sizeof($_POST['frmType']) - 1; $i++) {
    if ($_POST['frmType'][$i] == 'Dropdown from DB') {
        //Get dropdown text
        $tableFieldText = explode(".", $_POST['frmForeignkeytext'][$i]);
        $table = $tableFieldText[0];
        $fieldText = $tableFieldText[1];
        //Get dropdown value
        $tableFieldId = explode(".", $_POST['frmForeignkeyvalue'][$i]);
        $table = $tableFieldId[0];
        $fieldId = $tableFieldId[1];
        $makeDd .= "\$sql = \"SELECT $fieldId AS f1, $fieldText AS f2 FROM $table ORDER BY f2\";
	    \$this->load->model('_admin/get_general');
	    \$data['dd_" . $_POST['frmField'][$i] . "'] = \$this->get_general->riDropdown(\$sql);";
    }
}
$updateFunction.="
            //Make dropdown
            //Build SQL from dropdown and alias fields as f1 and f2
	    $makeDd
            //Make heading
            \$data['heading']='UPDATE " . strtoupper(str_replace('_', ' ', $_POST['frmFormsetvalue'])) . "';
            \$this->load->view('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_update',\$data);
	}        
";
$doaddFunction = "
        public function doadd()
	{
            checkLogin();
        ";
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);


    $doaddFunction.="
            //Check if at least one checkbox is selected
            if (empty(\$_POST['" . $f2 . "'])) {
                riPrintJs(\"alert('\" . \$this->lang->line('checkbox_check') . \"');\");
                exit;
            }
        ";
}
$doaddFunction .="        
            //Get remote scripting method
            \$remote = \$this->config->item('remote');
            ";
if ($_POST['table'] == 'sulata_settings') {
    $doaddFunction.="riExit('Operation not allowed.');
                    ";
}
$doaddFunction.="
            //Get table structure
            \$tbl = dbStructure_" . $_POST['table'] . "();
            
            //Validate";
//Build validation
$validation = "";
for ($i = 1; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if ($_POST['frmType'][$i] != 'Skip') {
        $validation.="
		    \$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "', '" . $_POST['frmLabel'][$i] . "', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|trim|htmlspecialchars|xss_clean');";
        //Check if password field
        if ($_POST['frmType'][$i] == 'Password') {
            $validation.="\$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "', 'Password', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|matches[" . $_POST['frmField'][$i] . "2]|trim|htmlspecialchars|xss_clean');
		    \$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "2', 'Confirm Password', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|trim|htmlspecialchars|xss_clean');";
        }
    }
}


$doaddFunction.="
	    $validation
            
            if (\$this->form_validation->run() == FALSE)
            {
                //If ajax;
                if(\$remote=='ajax'){
                    echo validation_errors('<li>', '</li>');
                     riPrintJS(\"
                         \$('#error-area ul').show();
                         \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                     \");
                
                //If iframe
                }else{
                    \$msg = validation_errors('<li>', '</li>');
                    \$msg = riRemoveLineBreaks(\$msg);
                    riPrintJS('
                         parent.\$(\"#error-area ul\").show();
                         parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                         parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                     ');
                
                }
                //
                
            }else{
                //Add data
                \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
                \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_doadd();
            }

            

        }
";
$doupdateFunction = "
        public function doupdate()
	{
            checkLogin();
        ";
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);


    $doupdateFunction.="
            //Check if at least one checkbox is selected
            if (empty(\$_POST['" . $f2 . "'])) {
                riPrintJs(\"alert('\" . \$this->lang->line('checkbox_check') . \"');\");
                exit;
            }
        ";
}
$doupdateFunction .="        

            //Get remote scripting method
            \$remote = \$this->config->item('remote');        
	                
            //Get table structure
            \$tbl = dbStructure_" . $_POST['table'] . "();
            
            //Validate";
//Build validation
$validation = "";
for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if (($_POST['frmType'][$i] != 'Skip') && ($_POST['frmField'][$i] != $_POST['primary'])) {
        $validation.="
		    \$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "', '" . $_POST['frmLabel'][$i] . "', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|trim|htmlspecialchars|xss_clean');";
        //Check if password field
        if ($_POST['frmType'][$i] == 'Password') {
            $validation.="\$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "', 'Password', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|matches[" . $_POST['frmField'][$i] . "2]|trim|htmlspecialchars|xss_clean');
		    \$this->form_validation->set_rules('" . $_POST['frmField'][$i] . "2', 'Confirm Password', \$tbl['" . $_POST['frmField'][$i] . "_jsreq'].'|trim|htmlspecialchars|xss_clean');";
        }
    }
}

$doupdateFunction.="
	    $validation
            if (\$this->form_validation->run() == FALSE)
            {
                //If ajax;
                if(\$remote=='ajax'){
                  echo validation_errors('<li>', '</li>');
                   riPrintJS(\"
                       \$('#error-area ul').show();
                       \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                   \");
                
                //If iframe
                }else{
                    \$msg = validation_errors('<li>', '</li>');
                    \$msg = riRemoveLineBreaks(\$msg);
                    riPrintJS('
                         parent.\$(\"#error-area ul\").show();
                         parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                         parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                     ');
                
                }
                //

            }else{
                //Update data
                
                \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
                \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_doupdate();
            }

            

        }
";
$dodeleteFunction = "
        public function delete()
	{
            checkLogin();
            ";
if ($_POST['table'] == 'sulata_settings') {
    $dodeleteFunction.="riExit('Operation not allowed.');
                    ";
}
$dodeleteFunction.="
            \$this->load->model('" . $_POST['frmSubFolder'] . "/" . $_POST['frmFormsetvalue'] . "_model');
            \$data = \$this->" . $_POST['frmFormsetvalue'] . "_model->" . $_POST['frmFormsetvalue'] . "_delete();             
        } 
";
$controllerText = str_replace('#INDEX_FUNCTION#', $indexFunction, $controllerText);
$controllerText = str_replace('#ADD_FUNCTION#', $addFunction, $controllerText);
$controllerText = str_replace('#UPDATE_FUNCTION#', $updateFunction, $controllerText);
$controllerText = str_replace('#DOADD_FUNCTION#', $doaddFunction, $controllerText);
$controllerText = str_replace('#DOUPDATE_FUNCTION#', $doupdateFunction, $controllerText);
$controllerText = str_replace('#DODELETE_FUNCTION#', $dodeleteFunction, $controllerText);
//Write controller
suWrite($controllerPath, $controllerText);
//Create models
$modelPath = $adminPath . '/models/' . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '_model.php';
$modelText = "<?php
class " . ucwords($_POST['frmFormsetvalue']) . "_model extends CI_Model{
    function " . $_POST['frmFormsetvalue'] . "_manage(){
            global \$i, \$where;
            \$data['table_data']='';
            if(\$this->input->get('q')!=''){
                \$where = \" AND " . $_POST['frmOrderby'] . " LIKE '%\".riStrip(\$this->input->get('q')).\"%' \";
            }
            
            \$config['base_url'] = admin_url().'" . $_POST['frmFormsetvalue'] . "/index/';
            \$config['total_rows'] = \$this->db->get('" . $_POST['table'] . "')->num_rows();
            \$config['per_page'] = \$this->config->item('per_page');
            \$config['num_links'] = \$this->config->item('num_links');
            \$config['full_tag_open'] = \$this->config->item('full_tag_open');
            \$config['full_tag_close'] = \$this->config->item('full_tag_close');
            \$config['uri_segment'] = '4';
            
            \$this->pagination->initialize(\$config);
            if(!\$this->uri->segment(4)){
                \$start =0;
            }else{
                \$start =\$this->uri->segment(4);
            }
            ";
$colsToMake = sizeof($_POST['frmShow']) - 1;
$colWidth = floor(90 / $colsToMake);
for ($i = 0; $i <= sizeof($_POST['frmShow']) - 1; $i++) {

    if (stristr($_POST['frmShow'][$i], "__date")) {
        //$d = explode('__',$_POST['frmShow'][$i]);

        $flds.=" \".riEnglishDate('" . $_POST['frmShow'][$i] . "').\" ,";
    } else {
        $flds.=$_POST['frmShow'][$i] . ",";
    }

    if ($_POST['frmShow'][$i] != $_POST['primary']) {
        $headerLabels.="array('data'=>'" . makeFieldLabel($_POST['frmShow'][$i]) . "','width'=>'" . $colWidth . "%'),";
    }
}
$flds = substr($flds, 0, -1);
$modelText.="
            \$sql = \"SELECT $flds FROM " . $_POST['table'] . "  WHERE 1=1 \$where ORDER BY " . $_POST['frmOrderby'] . " LIMIT \".\$start.','.\$config['per_page'];
            \$query = \$this->db->query(\$sql);
            if(\$query->num_rows()>0){
                \$data['i']='';
                foreach(\$query->result_array() as \$row){    
                    \$data['i']=\$data['i']+1; 
                    \$tbl[] = array(
                    \$data['i'].'.',
                    ";

//Make table
for ($i = 1; $i <= sizeof($_POST['frmShow']) - 1; $i++) {

    if ($i == 1) {
        $tr.="anchor(admin_url().'" . $_POST['frmFormsetvalue'] . "/update/'. riUnstrip(\$row['" . $_POST['primary'] . "']),riUnstrip(\$row['" . $_POST['frmShow'][$i] . "']),'title=\"'.\$this->lang->line('edit').'\"'),";
    } else {
        $tr.="riUnstrip(\$row['" . $_POST['frmShow'][$i] . "']),";
    }
}


$modelText.="
		    $tr
                    '<a href=\"javascript:;\" title=\"'.\$this->lang->line('delete').'\" onclick=\"riAjaxDelete(\''.\$this->lang->line('js_confirm').'\',\''.admin_url().'" . $_POST['frmFormsetvalue'] . "/delete/'. \$row['" . $_POST['primary'] . "'].'/\',this);\"><img src=\"'.base_url().'assets/css/images/icon-delete.png\" title=\"'.\$this->lang->line('delete').'\" alt=\"'.\$this->lang->line('delete').'\" border=\"1\" width=\"16\" height=\"16\"/></a>'
                    
		                 );
                }
                \$data['table_header']='';
                
		\$this->table->set_heading(array('data'=>'Sr.','width'=>'5%'),$headerLabels array('data'=>'&nbsp;','width'=>'5%'));
                \$data['table_data']= \$this->table->generate( \$tbl); 
                \$data['table_data'].=\$this->pagination->create_links();
		\$data['table_data'].='<script>\$(\'#table-area table tbody tr:odd\').css(\'background-color\', \'#eeeeee\');</script>';
		
            }else{
                \$data['table_header']='<h5>'.\$this->lang->line('no_record').'</h5>';    
            } 
            return \$data;
 }

    function " . $_POST['frmFormsetvalue'] . "_add(){
        //Get table structure
        \$data['tbl']=dbStructure_" . $_POST['table'] . "();
";
//Build details table checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);

    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);

    $modelText.="                    
        //Build checkboxes
        \$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " ORDER BY " . $f2 . "\";
        \$query = \$this->db->query(\$sql);
        if (\$query->num_rows() > 0) {
            \$data['chk'] = '';
            foreach (\$query->result_array() as \$row) {

                \$check = array(
                    'name' => '" . $f2 . "[]',
                    'id' => 'lbl_'.\$row['" . $f1 . "'],
                    'value' => \$row['" . $f1 . "'],
                    'checked' => FALSE,
                    'style' => 'margin:10px'
                );

                \$data['chk'].= '<div style=\"width:30%\" id=\"cat_'.\$row['" . $f1 . "'].'\"><label for=\"lbl_' . \$row['" . $f1 . "'] . '\">' . form_checkbox(\$check) . riUnstrip(\$row['" . $f2 . "']) . '</label></div>';

            }
        }

";
}
$modelText.="



        return \$data;
}

    function " . $_POST['frmFormsetvalue'] . "_doadd(){
        \$remote=\$this->config->item('remote');
        ";
if ($_POST['frmType'][$i] == 'File field') {
    $modelText.="
    \$uid=uniqid();
    ";
}
$modelText.="         
        //Add data
        
         \$data = array(
         ";
for ($i = 0; $i <= sizeof($_POST['frmField']) - 2; $i++) {
    $j = $i + 1;

    if (stristr($_POST['frmField'][$j], "__date")) {
        $postVal.="'" . $_POST['frmField'][$j] . "' => riDate2Db(\$this->input->post('" . $_POST['frmField'][$j] . "')),";
    } else {
        $postVal.="'" . $_POST['frmField'][$j] . "' => riStrip(\$this->input->post('" . $_POST['frmField'][$j] . "')),";
    }
}


//$postVal=substr($postVal,0,-2);
$modelText.="
            $postVal
         );

             \$this->db->insert('" . $_POST['table'] . "', \$data); 
             if(\$this->db->_error_number()>0){
                if(\$this->db->_error_number()==1062){ 

                    \$msg = sprintf(\$this->lang->line('db_duplicate'),\"'" . $_POST['unique'] . "'\");

                    //If ajax;
                    if(\$remote=='ajax'){
                        echo \"<li>{\$msg}</li>\";
                        riPrintJS(\"  
                            \$('#error-area ul').show();
                            \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                        \");
                    //If iframe
                    }else{
                        \$msg = \"<li>{\$msg}</li>\";
                        \$msg = riRemoveLineBreaks(\$msg);
                        riPrintJS('
                             parent.\$(\"#error-area ul\").show();
                             parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                             parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                         ');
                    }
                    //

                }else{
                     \$msg = \$this->lang->line('db_error');

                        //If ajax;
                        if(\$remote=='ajax'){
                            echo \"<li>{\$msg}</li>\";
                             riPrintJS(\"     
                                \$('#error-area ul').show();
                                \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                             \");
                        //If iframe
                        }else{
                            \$msg = \"<li>{\$msg}</li>\";
                            \$msg = riRemoveLineBreaks(\$msg);
                            riPrintJS('
                                 parent.\$(\"#error-area ul\").show();
                                 parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                                 parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                             ');
                        }
                        //
                 }
             }else{
                //If ajax;
                if(\$remote=='ajax'){
             ";
//Add details, checked boxes
//Get insert id

if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);


    $modelText.="
                //Add details, checked boxes
                //Get insert id
                \$max_id = \$this->db->insert_id();

                if (sizeof(\$_POST['" . $f2 . "']) > 0) {
                    foreach (\$_POST['" . $f2 . "'] as \$value) {
                        \$data = array(
                            '" . $f2a . "' => \$max_id,
                            '" . $f1a . "' => \$value
                        );
                        \$this->db->insert('" . $t1a . "', \$data);
                    }
                }
                ";
}
$modelText.="

                    riPrintJS(\" 
                        \$('#error-area ul').hide();
                        alert('\".\$this->lang->line('form_success').\"');
                        riReset();  
                        \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                    \");                         
                
                //If iframe
                }else{
                
";
//Add details, checked boxes
//Get insert id

if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);


    $modelText.="
                //Add details, checked boxes
                //Get insert id
                \$max_id = \$this->db->insert_id();

                if (sizeof(\$_POST['" . $f2 . "']) > 0) {
                    foreach (\$_POST['" . $f2 . "'] as \$value) {
                        \$data = array(
                            '" . $f2a . "' => \$max_id,
                            '" . $f1a . "' => \$value
                        );
                        \$this->db->insert('" . $t1a . "', \$data);
                    }
                }
                ";
}

for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if ($_POST['frmType'][$i] == 'File field') {
        $copycode .="
                            if(\$_FILES['" . $_POST['frmField'][$i] . "']['name']!=''){    
                                \$src=\$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'];
                                \$dest='./files/'.riFileName(\$_FILES['" . $_POST['frmField'][$i] . "']['name'],\$uid);
                                move_uploaded_file(\$src,\$dest); 
                            }
                            ";
    }
}
$modelText.="
                    $copycode
                    riPrintJS(\" 
                        parent.\$('#error-area ul').hide();
                        alert('\".\$this->lang->line('form_success').\"');
                        parent.riReset();  
                        parent.\$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                    \");                         
                
                }
                //             
             }           
    }

    function " . $_POST['frmFormsetvalue'] . "_update(){
            //Get table structure
             \$data['tbl']=dbStructure_" . $_POST['table'] . "();
            \$id = \$this->uri->segment(4);

";
//Build details table checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);

    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);

    $modelText.=" 

        //Build array of checked checkboxes
        \$sql = \"SELECT " . $f1a . " FROM " . $t1a . " WHERE " . $f2a . " 	 = '{\$id}'\";
        \$query = \$this->db->query(\$sql);
        \$check_row = \$query->result_array();
        \$checked_array = array();
        foreach (\$query->result_array() as \$row) {
            \$checked_array[] = \$row['" . $f1a . "'];
        }



            //Build checkboxes
            \$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " ORDER BY " . $f2 . "\";
            \$query = \$this->db->query(\$sql);
            if (\$query->num_rows() > 0) {
                \$data['chk'] = '';
                foreach (\$query->result_array() as \$row) {
                    if (in_array(\$row['" . $f1 . "'], \$checked_array)) {
                        \$chk = TRUE;
                    } else {
                        \$chk = FALSE;
                    }
                    \$check = array(
                        'name' => '" . $f2 . "[]',
                        'id' => 'lbl_'.\$row['" . $f1 . "'],
                        'value' => \$row['" . $f1 . "'],
                         'checked' => \$chk,
                        'style' => 'margin:10px'
                    );

                    \$data['chk'].= '<div style=\"width:30%\" id=\"cat_'.\$row['" . $f1 . "'].'\"><label for=\"lbl_' . \$row['" . $f1 . "'] . '\">' . form_checkbox(\$check) . riUnstrip(\$row['" . $f2 . "']) . '</label></div>';

                }
            }

";
}
$modelText.="
                    
            
            ";
$fld = "";
for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if (stristr($_POST['frmField'][$i], "__date")) {
        $fld.=" \".riDateFromDb('" . $_POST['frmField'][$i] . "').\",";
    } else {
        $fld.=$_POST['frmField'][$i] . ",";
    }
    $getUpdateFormValues .= "
                \$data['" . $_POST['frmField'][$i] . "']=riUnstrip(\$row['" . $_POST['frmField'][$i] . "']);
                ";
}
$fld = substr($fld, 0, -1);
$modelText.="
            \$sql = \"SELECT $fld FROM " . $_POST['table'] . " WHERE " . $_POST['primary'] . " = '{\$id}'\";

            \$query = \$this->db->query(\$sql);
            //If records available
            if (\$query->num_rows() > 0){
                foreach (\$query->result_array() as \$row)
                {
                    $getUpdateFormValues    
                }
                   

            }else{
                    //redirect
                    \$msg=\$this->lang->line('page_moved');
                    \$msg = urlencode(\$msg);
                    \$url = admin_url().'message/?msg='.\$msg;
                    redirect(\$url);     
            }  
            return \$data;
    }

    function " . $_POST['frmFormsetvalue'] . "_doupdate(){
        \$uid=uniqid();
        \$remote=\$this->config->item('remote');
        \$data = array(
        ";

$fld = "";
for ($i = 1; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if (stristr($_POST['frmField'][$i], "__date")) {
        $fld.="'" . $_POST['frmField'][$i] . "' => riDate2Db(\$this->input->post('" . $_POST['frmField'][$i] . "')),";
    } else {
        $fld.="'" . $_POST['frmField'][$i] . "' => riStrip(\$this->input->post('" . $_POST['frmField'][$i] . "')),";
    }
}


$modelText.="
            $fld
        );
           \$this->db->where('" . $_POST['primary'] . "', \$this->input->post('" . $_POST['primary'] . "'));
           \$this->db->update('" . $_POST['table'] . "', \$data); 
            if(\$this->db->_error_number()>0){
               if(\$this->db->_error_number()==1062){ 

                   \$msg = sprintf(\$this->lang->line('db_duplicate'),\"'" . $_POST['unique'] . "'\");
                    //If ajax;
                    if(\$remote=='ajax'){
                        echo \"<li>{\$msg}</li>\";
                        riPrintJS(\" 
                            \$('#error-area ul').show();
                            \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                        \");
                    //If iframe
                    }else{
                        \$msg = \"<li>{\$msg}</li>\";
                        \$msg = riRemoveLineBreaks(\$msg);
                        riPrintJS('
                             parent.\$(\"#error-area ul\").show();
                             parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                             parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                         ');
                    }
                    //


               }else{
                    \$msg = \$this->lang->line('db_error');
                    //If ajax;
                    if(\$remote=='ajax'){
                        echo \"<li>{\$msg}</li>\";
                        riPrintJS(\"     
                           \$('#error-area ul').show();
                           \$('html, body').animate({ scrollTop: \$('html').offset().top }, 'slow');
                        \");
                    }else{
                        \$msg = \"<li>{\$msg}</li>\";
                        \$msg = riRemoveLineBreaks(\$msg);
                        riPrintJS('
                             parent.\$(\"#error-area ul\").show();
                             parent.\$(\"#error-area ul\").html(\"'.\$msg.'\");
                             parent.\$(\"html, body\").animate({ scrollTop: \$(\"html\").offset().top }, \"slow\");
                         ');
                    }
                    //            


                }
            }else{
                //If ajax;
                if(\$remote=='ajax'){
                    riPrintJS(\"\$('#error-area ul').hide();\");                
                


             ";
//Add details, checked boxes
//Get insert id

if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);


    $modelText.="
                    //Add details, checked boxes
                    //Get insert id
                    \$max_id=\$this->input->post('" . $_POST['primary'] . "');    
                    \$this->db->delete('" . $t1a . "', array('" . $f2a . "' => \$max_id));           

                    if (sizeof(\$_POST['" . $f2 . "']) > 0) {
                        foreach (\$_POST['" . $f2 . "'] as \$value) {
                            \$data = array(
                                '" . $f2a . "' => \$max_id,
                                '" . $f1a . "' => \$value
                            );
                            \$this->db->insert('" . $t1a . "', \$data);
                        }
                    }
                    ";
}
$modelText.="



                
                //If iframe
                }else{
             ";
//Add details, checked boxes
//Get insert id

if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);


    $modelText.="
                    //Add details, checked boxes
                    //Get insert id
                    \$max_id=\$this->input->post('" . $_POST['primary'] . "');    
                    \$this->db->delete('" . $t1a . "', array('" . $f2a . "' => \$max_id));
           

                    if (sizeof(\$_POST['" . $f2 . "']) > 0) {
                        foreach (\$_POST['" . $f2 . "'] as \$value) {
                            \$data = array(
                                '" . $f2a . "' => \$max_id,
                                '" . $f1a . "' => \$value
                            );
                            \$this->db->insert('" . $t1a . "', \$data);
                        }
                    }
                    ";
}
$copycode = '';
for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    if ($_POST['frmType'][$i] == 'File field') {
        $copycode .="
                            if(\$_FILES['" . $_POST['frmField'][$i] . "']['name']!=''){    
                                \$src=\$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'];
                                \$dest='./files/'.riFileName(\$_FILES['" . $_POST['frmField'][$i] . "']['name'],\$uid);
                                 @unlink(\$dest);   
                                move_uploaded_file(\$src,\$dest); 
                            }
                            ";
    }
}

$modelText.="
                $copycode
                    riPrintJS('
                         parent.\$(\"#error-area ul\").hide();
                     ');
                }
                //            
";
if ($_POST['table'] == 'sulata_settings') {
    $modelText.="\$url = admin_url().'home/';";
} else {
    $modelText.="\$url = admin_url().'" . $_POST['frmFormsetvalue'] . "/';";
}
$modelText.="
                 
               riPrintJS(\"parent.window.location.href='{\$url}';\");                         
            }            
    }

    function " . $_POST['frmFormsetvalue'] . "_delete(){
        \$id = \$this->uri->segment(4);
        \$this->db->delete('" . $_POST['table'] . "', array('" . $_POST['primary'] . "' => \$id)); 
        
    }
}
";
//Write controller
suWrite($modelPath, $modelText);
//Create manage view
$manageViewPath = $adminPath . '/views/' . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '_manage.php';
$viewManage = "
                    <h2><?php echo \$heading;?></h2>
                        <!--SEARCH AREA-->
                        <?php  
                        \$arg = array('name'=>'searchForm','id'=>'searchForm','method'=> 'get');     
                        echo form_open(admin_url().'" . $_POST['frmFormsetvalue'] . "/',\$arg);
                        ?>
                            <fieldset id=\"search-area\">
                                <legend>Search by <?php echo \$search_string;?></legend>
                            <?php 
                            //Search field
                            \$arg = array('name'=>'q','id'=>'q');                            
                            echo form_input(\$arg);
                            //Submit button    
                            \$arg = array('name'=>'Submit','id'=>'Submit','value'=> 'Search');
                            echo form_submit(\$arg);
                            ?>
                            </fieldset>
                        <?php echo form_close();?>   

                    <div class=\"lineSpacer clear\"></div>
                    <!--TABLE AREA-->
                    <div id=\"table-area\">
                        <a href=\"<?php echo admin_url();?>" . $_POST['frmFormsetvalue'] . "/add/\">Add new..</a>
                           
                            <?php echo \$table_header;?>
                            <?php echo \$table_data;?>
                             
                            
                    </div>
                    <div class=\"lineSpacer clear\"></div>    
";
$template = file_get_contents('template/template.php');
//Write view template
$viewManage = str_replace('[RAPID-CODE]', $viewManage, $template);
suWrite($manageViewPath, $viewManage);
//Build add template
$addViewPath = $adminPath . '/views/' . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '_add.php';
$viewAdd = "
<div id=\"form-area\">
                        
                        <h2><?php echo \$heading;?></h2>
                        <?php
                        if (\$remote=='ajax') {
                            \$target = '_self';
                        } else {
                            \$target = 'remote';
                        }
                        \$arg = array('name' => 'riForm', 'id' => 'riForm', 'method' => 'post', 'target' => \$target);
                        ?>
                        <?php echo form_open_multipart(admin_url().'" . $_POST['frmFormsetvalue'] . "/doadd/',\$arg);?>
			";
$flds = "";
for ($i = 1; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    $tabIndex = $i * 10;
    if ($_POST['frmType'][$i] != 'Skip') {
        //If text, email, number
        if (($_POST['frmType'][$i] == 'Textbox') OR ($_POST['frmType'][$i] == 'Email') OR ($_POST['frmType'][$i] == 'Integer') OR ($_POST['frmType'][$i] == 'Float') OR ($_POST['frmType'][$i] == 'Double')) {
            $flds.="
			    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','maxlength'=>\$tbl['" . $_POST['frmField'][$i] . "_max'],'autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "');?>          
			    <div>
				<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:
</label>
				<?php echo form_input(\$arg);?>
			    </div>
    
				
				";
        }
        //If password
        if ($_POST['frmType'][$i] == 'Password') {
            $flds.="
				    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "');?>
				    <div>
					<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
					<?php echo form_password(\$arg);?>
				    </div>
				    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "2','id'=>'" . $_POST['frmField'][$i] . "2','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "');?>
				    <div>
					<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].'Confirm '.\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
					<?php echo form_password(\$arg);?>
				    </div>
				";
        }
    }

    //If textarea
    if (($_POST['frmType'][$i] == 'Textarea') OR ($_POST['frmType'][$i] == 'HTML Area')) {
        $flds.="
                        <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "', 'tabindex'=>'" . $tabIndex . "');?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_textarea(\$arg);?>
                        </div>
				";
    }


    //If file field
    if ($_POST['frmType'][$i] == 'File field') {
        $flds.="
                        <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "', 'tabindex'=>'" . $tabIndex . "');?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_upload(\$arg);?>
                        </div>

				";
    }


    //If enum
    if ($_POST['frmType'][$i] == 'Enum') {
        $flds.="
                        <?php
                        \$options = \$tbl['" . $_POST['frmField'][$i] . "_array'];
                        \$arg = \"id='" . $_POST['frmField'][$i] . "' tabindex='100'\"; 
                        ?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_dropdown('" . $_POST['frmField'][$i] . "',\$options,'" . $_POST['frmDefaultvalue'][$i] . "',\$arg);?>
                        </div>


				";
    }


    //If dropdown from DB
    if ($_POST['frmType'][$i] == 'Dropdown from DB') {
        $flds.="
                        <?php \$arg = \"id='" . $_POST['frmField'][$i] . "' tabindex='" . $tabIndex . "'\";?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:
                                
";
//Create refresh icon
//if($_POST['frmType'][$i]=='Dropdown from DB'){ 
        $ddsqltable = current(explode('.', $_POST['frmForeignkeyvalue'][$i]));
        $ddsql = "SELECT " . end(explode('.', $_POST['frmForeignkeyvalue'][$i])) . " AS f1, " . end(explode('.', $_POST['frmForeignkeytext'][$i])) . " AS f2 FROM " . $ddsqltable . " ORDER BY f2";
        $addpage = explode('_', $ddsqltable);
        $addpage = str_replace('sulata_', '', current(explode('.', $_POST['frmForeignkeyvalue'][$i])));
        $addpage = $addpage . '/add/';

        $flds.="
 <a href=\"<?php echo admin_url();?>" . $addpage . "\" target=\"_blank\"><img width=\"16\" height=\"16\" src=\"<?php echo base_url();?>assets/images/add-icon.png\" border=\"0\"/></a> 
     
<a href=\"javascript:;\" onclick=\"riReload('" . $_POST['frmField'][$i] . "','<?php echo admin_url();?>remote_dropdown/','<?php echo urlencode(\"" . $ddsql . "\");?>');\"><img width=\"16\" height=\"16\" src=\"<?php echo base_url();?>assets/images/reload-icon.png\" border=\"0\"/></a>    
    ";
//}
        $flds.="                               

</label>
                            <?php echo form_dropdown('" . $_POST['frmField'][$i] . "',\$dd_" . $_POST['frmField'][$i] . ",'',\$arg);?>
                        </div>
				";
    }
    //If date
    if ($_POST['frmType'][$i] == 'Date') {
        $flds.="
				
<?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "','class'=>'dateBox');?>
                        <div>
		<script>
		\$(function() {
			\$( '#" . $_POST['frmField'][$i] . "' ).datepicker({
				changeMonth: true,
				changeYear: true
				});
				\$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'yearRange', 'c-100:c+10' );
				\$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'dateFormat', '<?php echo \$this->config->item('date_format');?>' );
                                \$('#" . $_POST['frmField'][$i] . "').datepicker('setDate', '<?php if(\$this->config->item('date_format')=='mm-dd-yy'){echo date('m-d-Y');}else{echo date('d-m-Y');}?>' );                
		});
		
		</script>                      
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_input(\$arg);?>
                        </div>
				";
    }
}


$viewAdd.="
			$flds
                        <?php \$arg = array('name'=>'Submit','id'=>'Submit','value'=>'Submit', 'tabindex'=>'" . $tabIndex . "');?>

";
//Build checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    $t1a = strtoupper(str_replace('sulata_', '', $t1a));
    $t1a = strtoupper(str_replace('_', ' ', $t1a));
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);

    $viewAdd.="                    
                        <h2>ADD " . $t1a . "</h2>
                        <?php echo \$chk; ?>
";
}
$viewAdd.="
                        <p><?php echo form_submit(\$arg);?></p>
                        <?php echo form_close();?>
                        </div>
";
//Write view template
$viewAdd = str_replace('[RAPID-CODE]', $viewAdd, $template);
suWrite($addViewPath, $viewAdd);


//Build update template
$updateViewPath = $adminPath . '/views/' . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '_update.php';
$viewUpdate = "
<div id=\"form-area\">
                        
                        <h2><?php echo \$heading;?></h2>
                        <?php
                        if (\$remote=='ajax') {
                            \$target = '_self';
                        } else {
                            \$target = 'remote';
                        }
                        \$arg = array('name' => 'riForm', 'id' => 'riForm', 'method' => 'post', 'target' => \$target);
                        ?>

                        <?php echo form_open_multipart(admin_url().'" . $_POST['frmFormsetvalue'] . "/doupdate/',\$arg);?>
			";
$flds = "";
for ($i = 1; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    $tabIndex = $i * 10;
    if ($_POST['frmType'][$i] != 'Skip') {
        //If text, email, number
        if (($_POST['frmType'][$i] == 'Textbox') OR ($_POST['frmType'][$i] == 'Email') OR ($_POST['frmType'][$i] == 'Integer') OR ($_POST['frmType'][$i] == 'Float') OR ($_POST['frmType'][$i] == 'Double')) {
            $flds.="
			    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','maxlength'=>\$tbl['" . $_POST['frmField'][$i] . "_max'],'autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "','value'=>\$" . $_POST['frmField'][$i] . ");?>          
			    <div>
				<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
				<?php echo form_input(\$arg);?>
			    </div>
    
				
				";
        }
        //If password
        if ($_POST['frmType'][$i] == 'Password') {
            $flds.="
				    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "','value'=>\$" . $_POST['frmField'][$i] . ");?>
				    <div>
					<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
					<?php echo form_password(\$arg);?>
				    </div>
				    <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "2','id'=>'" . $_POST['frmField'][$i] . "2','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "','value'=>\$" . $_POST['frmField'][$i] . ");?>
				    <div>
					<label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].'Confirm '.\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
					<?php echo form_password(\$arg);?>
				    </div>
				";
        }
    }

    //If textarea
    if (($_POST['frmType'][$i] == 'Textarea') OR ($_POST['frmType'][$i] == 'HTML Area')) {
        $flds.="
                        <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "', 'tabindex'=>'" . $tabIndex . "','value'=>\$" . $_POST['frmField'][$i] . ");?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_textarea(\$arg);?>
                        </div>
				";
    }


    //If file field
    if ($_POST['frmType'][$i] == 'File field') {
        $flds.="
                        <?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "', 'tabindex'=>'" . $tabIndex . "','value'=>\$" . $_POST['frmField'][$i] . ");?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_upload(\$arg);?>
                        </div>

				";
    }


    //If enum
    if ($_POST['frmType'][$i] == 'Enum') {
        $flds.="
                        <?php
                        \$options = \$tbl['" . $_POST['frmField'][$i] . "_array'];
                        \$arg = \"id='" . $_POST['frmField'][$i] . "' tabindex='100'\"; 
                        ?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_dropdown('" . $_POST['frmField'][$i] . "',\$options,\$" . $_POST['frmField'][$i] . ",\$arg);?>
                        </div>


				";
    }


    //If dropdown from DB
    if ($_POST['frmType'][$i] == 'Dropdown from DB') {
        $flds.="
                        <?php \$arg = \"id='" . $_POST['frmField'][$i] . "' tabindex='" . $tabIndex . "'\";?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:
";
//Create refresh icon
//if($_POST['frmType'][$i]=='Dropdown from DB'){ 
        $ddsqltable = current(explode('.', $_POST['frmForeignkeyvalue'][$i]));
        $ddsql = "SELECT " . end(explode('.', $_POST['frmForeignkeyvalue'][$i])) . " AS f1, " . end(explode('.', $_POST['frmForeignkeytext'][$i])) . " AS f2 FROM " . $ddsqltable . " ORDER BY f2";
        $addpage = explode('_', $ddsqltable);
        $addpage = str_replace('sulata_', '', current(explode('.', $_POST['frmForeignkeyvalue'][$i])));
        $addpage = $addpage . '/add/';

        $flds.="
 <a href=\"<?php echo admin_url();?>" . $addpage . "\" target=\"_blank\"><img width=\"16\" height=\"16\" src=\"<?php echo base_url();?>assets/images/add-icon.png\" border=\"0\"/></a> 
     
<a href=\"javascript:;\" onclick=\"riReload('" . $_POST['frmField'][$i] . "','<?php echo admin_url();?>remote_dropdown/','<?php echo urlencode(\"" . $ddsql . "\");?>');\"><img width=\"16\" height=\"16\" src=\"<?php echo base_url();?>assets/images/reload-icon.png\" border=\"0\"/></a>    
    ";
//}
        $flds.="                               
</label>
                            <?php echo form_dropdown('" . $_POST['frmField'][$i] . "',\$dd_" . $_POST['frmField'][$i] . ",\$" . $_POST['frmField'][$i] . ",\$arg);?>
                        </div>
				";
    }
    //If date
    if ($_POST['frmType'][$i] == 'Date') {
        $flds.="
				
<?php \$arg = array('name'=>'" . $_POST['frmField'][$i] . "','id'=>'" . $_POST['frmField'][$i] . "','autocomplete'=>'off', 'tabindex'=>'" . $tabIndex . "','class'=>'dateBox');?>
                        <div>
                            <label><?php echo \$tbl['" . $_POST['frmField'][$i] . "_req'].\$tbl['" . $_POST['frmField'][$i] . "_title'];?>:</label>
                            <?php echo form_input(\$arg);?>
                        </div>
			
		<script>
		\$(function() {
			 \$( '#" . $_POST['frmField'][$i] . "' ).datepicker({
				changeMonth: true,
				changeYear: true
				});
				\$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'yearRange', 'c-100:c+10' );
				\$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'dateFormat', '<?php echo \$this->config->item('date_format');?>' );
                                \$('#" . $_POST['frmField'][$i] . "').datepicker('setDate', '<?php echo \$" . $_POST['frmField'][$i] . ";?>' );                
		});
		
		</script>
		
				";
    }
}


$viewUpdate.="
			$flds
			<?php echo form_hidden('" . $_POST['primary'] . "',\$" . $_POST['primary'] . ");?>

                        <?php \$arg = array('name'=>'submit','id'=>'submit','value'=>'Submit', 'tabindex'=>'" . $tabIndex . "');?>

";
//Build checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);
    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);
    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    $t1a = strtoupper(str_replace('sulata_', '', $t1a));
    $t1a = strtoupper(str_replace('_', ' ', $t1a));
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);

    $viewUpdate.="                    
                        <h2>ADD " . $t1a . "</h2>
                        <?php echo \$chk; ?>
";
}
$viewUpdate.="                            
                        <p><?php echo form_submit(\$arg);?></p>
                        <?php echo form_close();?>
                        </div>

";
//Write view template
$viewUpdate = str_replace('[RAPID-CODE]', $viewUpdate, $template);
suWrite($updateViewPath, $viewUpdate);
echo "
<script>
top.$('#result').html(top.$('#result').html()+'" . $_POST['frmFormsetvalue'] . " formset created.<br/>');
</script>
";
?>