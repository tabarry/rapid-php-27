<?php
     $dbs_sulata_blank =
        array(
        
            '__ID_req'=>'*',
            '__ID_title'=>'ID',
            '__ID_max'=>'11',
            '__ID_validateas'=>'int',
            '__ID_html5_req'=>'required',
            '__ID_html5_type'=>'number',
            
            
            '__Sort_Order_req'=>'*',
            '__Sort_Order_title'=>'Sort Order',
            '__Sort_Order_max'=>'11',
            '__Sort_Order_validateas'=>'int',
            '__Sort_Order_html5_req'=>'required',
            '__Sort_Order_html5_type'=>'number',
            
            
            '__Last_Action_On_req'=>'*',
            '__Last_Action_On_title'=>'Last Action On',
            '__Last_Action_On_max'=>'',
            '__Last_Action_On_validateas'=>'required',
            '__Last_Action_On_html5_req'=>'required',
            '__Last_Action_On_html5_type'=>'text',
            
            
            '__Last_Action_By_req'=>'*',
            '__Last_Action_By_title'=>'Last Action By',
            '__Last_Action_By_max'=>'64',
            '__Last_Action_By_validateas'=>'required',
            '__Last_Action_By_html5_req'=>'required',
            '__Last_Action_By_html5_type'=>'text',
            
            
            '__dbState_req'=>'*',
            '__dbState_title'=>'dbState',
            '__dbState_max'=>'',
            '__dbState_validateas'=>'enum',
            '__dbState_html5_req'=>'required',
            '__dbState_html5_type'=>'text',
            '__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_faqs =
        array(
        
            'faq__ID_req'=>'*',
            'faq__ID_title'=>'ID',
            'faq__ID_max'=>'11',
            'faq__ID_validateas'=>'int',
            'faq__ID_html5_req'=>'required',
            'faq__ID_html5_type'=>'number',
            
            
            'faq__Question_req'=>'*',
            'faq__Question_title'=>'Question',
            'faq__Question_max'=>'255',
            'faq__Question_validateas'=>'required',
            'faq__Question_html5_req'=>'required',
            'faq__Question_html5_type'=>'text',
            
            
            'faq__Answer_req'=>'*',
            'faq__Answer_title'=>'Answer',
            'faq__Answer_max'=>'',
            'faq__Answer_validateas'=>'required',
            'faq__Answer_html5_req'=>'required',
            'faq__Answer_html5_type'=>'text',
            
            
            'faq__Status_req'=>'*',
            'faq__Status_title'=>'Status',
            'faq__Status_max'=>'',
            'faq__Status_validateas'=>'enum',
            'faq__Status_html5_req'=>'required',
            'faq__Status_html5_type'=>'text',
            'faq__Status_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'faq__Sort_Order_req'=>'*',
            'faq__Sort_Order_title'=>'Sort Order',
            'faq__Sort_Order_max'=>'11',
            'faq__Sort_Order_validateas'=>'int',
            'faq__Sort_Order_html5_req'=>'required',
            'faq__Sort_Order_html5_type'=>'number',
            
            
            'faq__Last_Action_On_req'=>'*',
            'faq__Last_Action_On_title'=>'Last Action On',
            'faq__Last_Action_On_max'=>'',
            'faq__Last_Action_On_validateas'=>'required',
            'faq__Last_Action_On_html5_req'=>'required',
            'faq__Last_Action_On_html5_type'=>'text',
            
            
            'faq__Last_Action_By_req'=>'*',
            'faq__Last_Action_By_title'=>'Last Action By',
            'faq__Last_Action_By_max'=>'64',
            'faq__Last_Action_By_validateas'=>'required',
            'faq__Last_Action_By_html5_req'=>'required',
            'faq__Last_Action_By_html5_type'=>'text',
            
            
            'faq__dbState_req'=>'*',
            'faq__dbState_title'=>'dbState',
            'faq__dbState_max'=>'',
            'faq__dbState_validateas'=>'enum',
            'faq__dbState_html5_req'=>'required',
            'faq__dbState_html5_type'=>'text',
            'faq__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_groups =
        array(
        
            'group__ID_req'=>'*',
            'group__ID_title'=>'ID',
            'group__ID_max'=>'11',
            'group__ID_validateas'=>'int',
            'group__ID_html5_req'=>'required',
            'group__ID_html5_type'=>'number',
            
            
            'group__Name_req'=>'*',
            'group__Name_title'=>'Name',
            'group__Name_max'=>'64',
            'group__Name_validateas'=>'required',
            'group__Name_html5_req'=>'required',
            'group__Name_html5_type'=>'text',
            
            
            'group__Status_req'=>'*',
            'group__Status_title'=>'Status',
            'group__Status_max'=>'',
            'group__Status_validateas'=>'enum',
            'group__Status_html5_req'=>'required',
            'group__Status_html5_type'=>'text',
            'group__Status_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'group__Permissions_req'=>'*',
            'group__Permissions_title'=>'Permissions',
            'group__Permissions_max'=>'',
            'group__Permissions_validateas'=>'required',
            'group__Permissions_html5_req'=>'required',
            'group__Permissions_html5_type'=>'text',
            
            
            'group__Sort_Order_req'=>'*',
            'group__Sort_Order_title'=>'Sort Order',
            'group__Sort_Order_max'=>'11',
            'group__Sort_Order_validateas'=>'int',
            'group__Sort_Order_html5_req'=>'required',
            'group__Sort_Order_html5_type'=>'number',
            
            
            'group__Last_Action_On_req'=>'*',
            'group__Last_Action_On_title'=>'Last Action On',
            'group__Last_Action_On_max'=>'',
            'group__Last_Action_On_validateas'=>'required',
            'group__Last_Action_On_html5_req'=>'required',
            'group__Last_Action_On_html5_type'=>'text',
            
            
            'group__Last_Action_By_req'=>'*',
            'group__Last_Action_By_title'=>'Last Action By',
            'group__Last_Action_By_max'=>'64',
            'group__Last_Action_By_validateas'=>'required',
            'group__Last_Action_By_html5_req'=>'required',
            'group__Last_Action_By_html5_type'=>'text',
            
            
            'group__dbState_req'=>'*',
            'group__dbState_title'=>'dbState',
            'group__dbState_max'=>'',
            'group__dbState_validateas'=>'enum',
            'group__dbState_html5_req'=>'required',
            'group__dbState_html5_type'=>'text',
            'group__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_headers =
        array(
        
            'header__ID_req'=>'*',
            'header__ID_title'=>'ID',
            'header__ID_max'=>'11',
            'header__ID_validateas'=>'int',
            'header__ID_html5_req'=>'required',
            'header__ID_html5_type'=>'number',
            
            
            'header__Title_req'=>'*',
            'header__Title_title'=>'Title',
            'header__Title_max'=>'64',
            'header__Title_validateas'=>'required',
            'header__Title_html5_req'=>'required',
            'header__Title_html5_type'=>'text',
            
            
            'header__Picture_req'=>'*',
            'header__Picture_title'=>'Picture',
            'header__Picture_max'=>'128',
            'header__Picture_validateas'=>'image',
            'header__Picture_html5_req'=>'required',
            'header__Picture_html5_type'=>'file',
            
            
            'header__Sort_Order_req'=>'*',
            'header__Sort_Order_title'=>'Sort Order',
            'header__Sort_Order_max'=>'11',
            'header__Sort_Order_validateas'=>'int',
            'header__Sort_Order_html5_req'=>'required',
            'header__Sort_Order_html5_type'=>'number',
            
            
            'header__Last_Action_On_req'=>'*',
            'header__Last_Action_On_title'=>'Last Action On',
            'header__Last_Action_On_max'=>'',
            'header__Last_Action_On_validateas'=>'required',
            'header__Last_Action_On_html5_req'=>'required',
            'header__Last_Action_On_html5_type'=>'text',
            
            
            'header__Last_Action_By_req'=>'*',
            'header__Last_Action_By_title'=>'Last Action By',
            'header__Last_Action_By_max'=>'64',
            'header__Last_Action_By_validateas'=>'required',
            'header__Last_Action_By_html5_req'=>'required',
            'header__Last_Action_By_html5_type'=>'text',
            
            
            'header__dbState_req'=>'*',
            'header__dbState_title'=>'dbState',
            'header__dbState_max'=>'',
            'header__dbState_validateas'=>'enum',
            'header__dbState_html5_req'=>'required',
            'header__dbState_html5_type'=>'text',
            'header__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_media =
        array(
        
            'media__ID_req'=>'*',
            'media__ID_title'=>'ID',
            'media__ID_max'=>'11',
            'media__ID_validateas'=>'int',
            'media__ID_html5_req'=>'required',
            'media__ID_html5_type'=>'number',
            
            
            'media__Title_req'=>'*',
            'media__Title_title'=>'Title',
            'media__Title_max'=>'100',
            'media__Title_validateas'=>'required',
            'media__Title_html5_req'=>'required',
            'media__Title_html5_type'=>'text',
            
            
            'media__File_req'=>'*',
            'media__File_title'=>'File',
            'media__File_max'=>'255',
            'media__File_validateas'=>'file',
            'media__File_html5_req'=>'required',
            'media__File_html5_type'=>'file',
            
            
            'media__Sort_Order_req'=>'*',
            'media__Sort_Order_title'=>'Sort Order',
            'media__Sort_Order_max'=>'11',
            'media__Sort_Order_validateas'=>'int',
            'media__Sort_Order_html5_req'=>'required',
            'media__Sort_Order_html5_type'=>'number',
            
            
            'media__Last_Action_On_req'=>'*',
            'media__Last_Action_On_title'=>'Last Action On',
            'media__Last_Action_On_max'=>'',
            'media__Last_Action_On_validateas'=>'required',
            'media__Last_Action_On_html5_req'=>'required',
            'media__Last_Action_On_html5_type'=>'text',
            
            
            'media__Last_Action_By_req'=>'*',
            'media__Last_Action_By_title'=>'Last Action By',
            'media__Last_Action_By_max'=>'64',
            'media__Last_Action_By_validateas'=>'required',
            'media__Last_Action_By_html5_req'=>'required',
            'media__Last_Action_By_html5_type'=>'text',
            
            
            'media__dbState_req'=>'*',
            'media__dbState_title'=>'dbState',
            'media__dbState_max'=>'',
            'media__dbState_validateas'=>'enum',
            'media__dbState_html5_req'=>'required',
            'media__dbState_html5_type'=>'text',
            'media__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_pages =
        array(
        
            'page__ID_req'=>'*',
            'page__ID_title'=>'ID',
            'page__ID_max'=>'11',
            'page__ID_validateas'=>'int',
            'page__ID_html5_req'=>'required',
            'page__ID_html5_type'=>'number',
            
            
            'page__Name_req'=>'*',
            'page__Name_title'=>'Name',
            'page__Name_max'=>'64',
            'page__Name_validateas'=>'required',
            'page__Name_html5_req'=>'required',
            'page__Name_html5_type'=>'text',
            
            
            'page__Permalink_req'=>'*',
            'page__Permalink_title'=>'Permalink',
            'page__Permalink_max'=>'64',
            'page__Permalink_validateas'=>'required',
            'page__Permalink_html5_req'=>'required',
            'page__Permalink_html5_type'=>'text',
            
            
            'page__Title_req'=>'*',
            'page__Title_title'=>'Title',
            'page__Title_max'=>'70',
            'page__Title_validateas'=>'required',
            'page__Title_html5_req'=>'required',
            'page__Title_html5_type'=>'text',
            
            
            'page__Keyword_req'=>'*',
            'page__Keyword_title'=>'Keyword',
            'page__Keyword_max'=>'255',
            'page__Keyword_validateas'=>'required',
            'page__Keyword_html5_req'=>'required',
            'page__Keyword_html5_type'=>'text',
            
            
            'page__Description_req'=>'*',
            'page__Description_title'=>'Description',
            'page__Description_max'=>'155',
            'page__Description_validateas'=>'required',
            'page__Description_html5_req'=>'required',
            'page__Description_html5_type'=>'text',
            
            
            'page__Header_req'=>'*',
            'page__Header_title'=>'Header',
            'page__Header_max'=>'11',
            'page__Header_validateas'=>'int',
            'page__Header_html5_req'=>'required',
            'page__Header_html5_type'=>'number',
            
            
            'page__Short_Text_req'=>'',
            'page__Short_Text_title'=>'Short Text',
            'page__Short_Text_max'=>'',
            'page__Short_Text_validateas'=>'',
            'page__Short_Text_html5_req'=>'',
            'page__Short_Text_html5_type'=>'text',
            
            
            'page__Long_Text_req'=>'*',
            'page__Long_Text_title'=>'Long Text',
            'page__Long_Text_max'=>'',
            'page__Long_Text_validateas'=>'required',
            'page__Long_Text_html5_req'=>'required',
            'page__Long_Text_html5_type'=>'text',
            
            
            'page__Sort_Order_req'=>'*',
            'page__Sort_Order_title'=>'Sort Order',
            'page__Sort_Order_max'=>'11',
            'page__Sort_Order_validateas'=>'int',
            'page__Sort_Order_html5_req'=>'required',
            'page__Sort_Order_html5_type'=>'number',
            
            
            'page__Last_Action_On_req'=>'*',
            'page__Last_Action_On_title'=>'Last Action On',
            'page__Last_Action_On_max'=>'',
            'page__Last_Action_On_validateas'=>'required',
            'page__Last_Action_On_html5_req'=>'required',
            'page__Last_Action_On_html5_type'=>'text',
            
            
            'page__Last_Action_By_req'=>'*',
            'page__Last_Action_By_title'=>'Last Action By',
            'page__Last_Action_By_max'=>'64',
            'page__Last_Action_By_validateas'=>'required',
            'page__Last_Action_By_html5_req'=>'required',
            'page__Last_Action_By_html5_type'=>'text',
            
            
            'page__dbState_req'=>'*',
            'page__dbState_title'=>'dbState',
            'page__dbState_max'=>'',
            'page__dbState_validateas'=>'enum',
            'page__dbState_html5_req'=>'required',
            'page__dbState_html5_type'=>'text',
            'page__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_settings =
        array(
        
            'setting__ID_req'=>'*',
            'setting__ID_title'=>'ID',
            'setting__ID_max'=>'11',
            'setting__ID_validateas'=>'int',
            'setting__ID_html5_req'=>'required',
            'setting__ID_html5_type'=>'number',
            
            
            'setting__Type_req'=>'*',
            'setting__Type_title'=>'Type',
            'setting__Type_max'=>'',
            'setting__Type_validateas'=>'enum',
            'setting__Type_html5_req'=>'required',
            'setting__Type_html5_type'=>'text',
            'setting__Type_array'=>array(''=>'Select..','Text'=>'Text','Dropdown'=>'Dropdown',),
            
            'setting__Options_req'=>'',
            'setting__Options_title'=>'Options',
            'setting__Options_max'=>'50',
            'setting__Options_validateas'=>'',
            'setting__Options_html5_req'=>'',
            'setting__Options_html5_type'=>'text',
            
            
            'setting__Setting_req'=>'*',
            'setting__Setting_title'=>'Setting',
            'setting__Setting_max'=>'64',
            'setting__Setting_validateas'=>'required',
            'setting__Setting_html5_req'=>'required',
            'setting__Setting_html5_type'=>'text',
            
            
            'setting__Key_req'=>'*',
            'setting__Key_title'=>'Key',
            'setting__Key_max'=>'64',
            'setting__Key_validateas'=>'required',
            'setting__Key_html5_req'=>'required',
            'setting__Key_html5_type'=>'text',
            
            
            'setting__Value_req'=>'*',
            'setting__Value_title'=>'Value',
            'setting__Value_max'=>'256',
            'setting__Value_validateas'=>'required',
            'setting__Value_html5_req'=>'required',
            'setting__Value_html5_type'=>'text',
            
            
            'setting__Scope_req'=>'*',
            'setting__Scope_title'=>'Scope',
            'setting__Scope_max'=>'',
            'setting__Scope_validateas'=>'enum',
            'setting__Scope_html5_req'=>'required',
            'setting__Scope_html5_type'=>'text',
            'setting__Scope_array'=>array(''=>'Select..','Public'=>'Public','Private'=>'Private',),
            
            'setting__Sort_Order_req'=>'*',
            'setting__Sort_Order_title'=>'Sort Order',
            'setting__Sort_Order_max'=>'11',
            'setting__Sort_Order_validateas'=>'int',
            'setting__Sort_Order_html5_req'=>'required',
            'setting__Sort_Order_html5_type'=>'number',
            
            
            'setting__Last_Action_On_req'=>'*',
            'setting__Last_Action_On_title'=>'Last Action On',
            'setting__Last_Action_On_max'=>'',
            'setting__Last_Action_On_validateas'=>'required',
            'setting__Last_Action_On_html5_req'=>'required',
            'setting__Last_Action_On_html5_type'=>'text',
            
            
            'setting__Last_Action_By_req'=>'*',
            'setting__Last_Action_By_title'=>'Last Action By',
            'setting__Last_Action_By_max'=>'64',
            'setting__Last_Action_By_validateas'=>'required',
            'setting__Last_Action_By_html5_req'=>'required',
            'setting__Last_Action_By_html5_type'=>'text',
            
            
            'setting__dbState_req'=>'*',
            'setting__dbState_title'=>'dbState',
            'setting__dbState_max'=>'',
            'setting__dbState_validateas'=>'enum',
            'setting__dbState_html5_req'=>'required',
            'setting__dbState_html5_type'=>'text',
            'setting__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_user_groups =
        array(
        
            'usergroup__ID_req'=>'*',
            'usergroup__ID_title'=>'ID',
            'usergroup__ID_max'=>'11',
            'usergroup__ID_validateas'=>'int',
            'usergroup__ID_html5_req'=>'required',
            'usergroup__ID_html5_type'=>'number',
            
            
            'usergroup__Group_req'=>'*',
            'usergroup__Group_title'=>'Group',
            'usergroup__Group_max'=>'11',
            'usergroup__Group_validateas'=>'int',
            'usergroup__Group_html5_req'=>'required',
            'usergroup__Group_html5_type'=>'number',
            
            
            'usergroup__User_req'=>'*',
            'usergroup__User_title'=>'User',
            'usergroup__User_max'=>'11',
            'usergroup__User_validateas'=>'int',
            'usergroup__User_html5_req'=>'required',
            'usergroup__User_html5_type'=>'number',
            
            
            'usergroup__Sort_Order_req'=>'*',
            'usergroup__Sort_Order_title'=>'Sort Order',
            'usergroup__Sort_Order_max'=>'11',
            'usergroup__Sort_Order_validateas'=>'int',
            'usergroup__Sort_Order_html5_req'=>'required',
            'usergroup__Sort_Order_html5_type'=>'number',
            
            
            'usergroup__Last_Action_On_req'=>'*',
            'usergroup__Last_Action_On_title'=>'Last Action On',
            'usergroup__Last_Action_On_max'=>'',
            'usergroup__Last_Action_On_validateas'=>'required',
            'usergroup__Last_Action_On_html5_req'=>'required',
            'usergroup__Last_Action_On_html5_type'=>'text',
            
            
            'usergroup__Last_Action_By_req'=>'*',
            'usergroup__Last_Action_By_title'=>'Last Action By',
            'usergroup__Last_Action_By_max'=>'64',
            'usergroup__Last_Action_By_validateas'=>'required',
            'usergroup__Last_Action_By_html5_req'=>'required',
            'usergroup__Last_Action_By_html5_type'=>'text',
            
            
            'usergroup__dbState_req'=>'*',
            'usergroup__dbState_title'=>'dbState',
            'usergroup__dbState_max'=>'',
            'usergroup__dbState_validateas'=>'enum',
            'usergroup__dbState_html5_req'=>'required',
            'usergroup__dbState_html5_type'=>'text',
            'usergroup__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );

    $dbs_sulata_users =
        array(
        
            'user__ID_req'=>'*',
            'user__ID_title'=>'ID',
            'user__ID_max'=>'11',
            'user__ID_validateas'=>'int',
            'user__ID_html5_req'=>'required',
            'user__ID_html5_type'=>'number',
            
            
            'user__Name_req'=>'*',
            'user__Name_title'=>'Name',
            'user__Name_max'=>'32',
            'user__Name_validateas'=>'required',
            'user__Name_html5_req'=>'required',
            'user__Name_html5_type'=>'text',
            
            
            'user__Email_req'=>'*',
            'user__Email_title'=>'Email',
            'user__Email_max'=>'64',
            'user__Email_validateas'=>'email',
            'user__Email_html5_req'=>'required',
            'user__Email_html5_type'=>'email',
            
            
            'user__Password_req'=>'*',
            'user__Password_title'=>'Password',
            'user__Password_max'=>'64',
            'user__Password_validateas'=>'password',
            'user__Password_html5_req'=>'required',
            'user__Password_html5_type'=>'password',
            
            
            'user__Picture_req'=>'',
            'user__Picture_title'=>'Picture',
            'user__Picture_max'=>'128',
            'user__Picture_validateas'=>'image',
            'user__Picture_html5_req'=>'',
            'user__Picture_html5_type'=>'file',
            
            
            'user__Status_req'=>'*',
            'user__Status_title'=>'Status',
            'user__Status_max'=>'',
            'user__Status_validateas'=>'enum',
            'user__Status_html5_req'=>'required',
            'user__Status_html5_type'=>'text',
            'user__Status_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'user__Notes_req'=>'',
            'user__Notes_title'=>'Notes',
            'user__Notes_max'=>'',
            'user__Notes_validateas'=>'',
            'user__Notes_html5_req'=>'',
            'user__Notes_html5_type'=>'text',
            
            
            'user__Theme_req'=>'*',
            'user__Theme_title'=>'Theme',
            'user__Theme_max'=>'24',
            'user__Theme_validateas'=>'required',
            'user__Theme_html5_req'=>'required',
            'user__Theme_html5_type'=>'text',
            
            
            'user__Type_req'=>'*',
            'user__Type_title'=>'Type',
            'user__Type_max'=>'',
            'user__Type_validateas'=>'enum',
            'user__Type_html5_req'=>'required',
            'user__Type_html5_type'=>'text',
            'user__Type_array'=>array(''=>'Select..','Private'=>'Private','Public'=>'Public',),
            
            'user__Sort_Order_req'=>'*',
            'user__Sort_Order_title'=>'Sort Order',
            'user__Sort_Order_max'=>'11',
            'user__Sort_Order_validateas'=>'int',
            'user__Sort_Order_html5_req'=>'required',
            'user__Sort_Order_html5_type'=>'number',
            
            
            'user__Password_Reset_req'=>'*',
            'user__Password_Reset_title'=>'Password Reset',
            'user__Password_Reset_max'=>'',
            'user__Password_Reset_validateas'=>'enum',
            'user__Password_Reset_html5_req'=>'required',
            'user__Password_Reset_html5_type'=>'password',
            'user__Password_Reset_array'=>array(''=>'Select..','Yes'=>'Yes','No'=>'No',),
            
            'user__Last_Action_On_req'=>'*',
            'user__Last_Action_On_title'=>'Last Action On',
            'user__Last_Action_On_max'=>'',
            'user__Last_Action_On_validateas'=>'required',
            'user__Last_Action_On_html5_req'=>'required',
            'user__Last_Action_On_html5_type'=>'text',
            
            
            'user__Last_Action_By_req'=>'*',
            'user__Last_Action_By_title'=>'Last Action By',
            'user__Last_Action_By_max'=>'64',
            'user__Last_Action_By_validateas'=>'required',
            'user__Last_Action_By_html5_req'=>'required',
            'user__Last_Action_By_html5_type'=>'text',
            
            
            'user__dbState_req'=>'*',
            'user__dbState_title'=>'dbState',
            'user__dbState_max'=>'',
            'user__dbState_validateas'=>'enum',
            'user__dbState_html5_req'=>'required',
            'user__dbState_html5_type'=>'text',
            'user__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
            'user__IP_req'=>'*',
            'user__IP_title'=>'IP',
            'user__IP_max'=>'15',
            'user__IP_validateas'=>'required',
            'user__IP_html5_req'=>'required',
            'user__IP_html5_type'=>'text',
            
            
        );

    $uniqueArray = array('faq__Question','group__Name','header__Title','media__Title','page__Name','setting__Setting','setting__Key','user__Email');