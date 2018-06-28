<?php

return [
    'title' => 'Teknoza CMS',
    'edit' => 'Edit',
    'remove' => 'Remove',
    'view' => 'View',
    'actions' => 'Actions',
    'cancel' => 'Cancel',
    'yes' => 'Yes',
    'no' => 'No',
    'details' => 'Details',
    
    /* Menu */
    'menu_dashboard' => 'Dashboard',
    'menu_settings' => 'Settings',
    'menu_settings_global' => 'Global Settings',
    'menu_settings_users' => 'Admin Users',
    'menu_settings_statistics' => 'Statistics',
    'menu_settings_locales' => 'Locales',
    'menu_settings_translations' => 'Translations',
    
    /* Template */
    'template_title' => 'Administrator | Teknoza CMS',
    
    /* Profile */
    'profile_page_title' => 'Profile',
    'profile_page_description' => 'You can change your profile here.',
    'profile_remove_avatar' => 'Remove Avatar',
    'profile_select_avatar' => 'Select Avatar',
    'profile_name' => 'Name',
    'profile_surname' => 'Surname',
    'profile_password' => 'Password',
    'profile_repassword' => 'Retype Password',
    'profile_password_info' => 'Your password must be at least 6 characters long.',
    'profile_submit' => 'Update Profile',
    
    /* Profile/Messages */
    'profile_msg_updated' => 'Your profile has been successfully updated.',

    /* Index */
    'index_dashboard' => 'Dashboard',
    'index_empty' => 'If you want to see statistics on Dashboard, enter Google Analytics details <a href=":url">here</a>.',
    'index_stat_visitors_last_day' => 'Visitors Last Day',
    'index_stat_visitors_last_month' => 'Visitors Last Month',
    'index_stat_visitors_today' => 'Visitors Today',
    'index_stat_page_views_today' => 'Page Views Today',
    'index_stat_visitors_yesterday' => 'Visitors Yesterday',
    'index_stat_page_views_yesterday' => 'Page Views Yesterday',
    'index_stat_visitors_this_month' => 'Visitors This Month',
    'index_stat_page_views_this_month' => 'Page Views This Month',
    'index_stat_visitors_last_month' => 'Visitors Last Month',
    'index_stat_page_views_last_month' => 'Page Views Last Month',
    
    /* Auth/Login */
    'auth_login_description' => 'Welcome to Teknoza CMS! Login and manage your website easily.',
    'auth_login_errors' => 'User email or password is incorrect. Try again.',
    'auth_login_reset_sent' => 'We just sent you details about your password reset.',
    'auth_login_reset_success' => 'Your new password has been sent to your email address.',
    'auth_login_forgot' => 'Forgot password',
    'auth_login_email' => 'E-mail',
    'auth_login_password' => 'Password',
    'auth_login_submit' => 'Login',
    'auth_login_version' => 'Teknoza CMS version :version',
    
    /* Auth/Forgot */
    'auth_forgot_title' => 'Forgot Password',
    'auth_forgot_description' => 'You can recover you password here by entering your email address.',
    'auth_forgot_email' => 'Your email address',
    'auth_forgot_back' => 'Back',
    'auth_forgot_submit' => 'Recover Password',
    'auth_forgot_success' => 'Your reset password link has been sent your email address.',
    'auth_forgot_errors' => 'We did not find existing email address.',

    /* Settings/Global */
    'settings_global_page_title' => 'Global Settings',
    'settings_global_page_description' => 'You can change here you pare settings.',
    'settings_global_submit' => 'Save Settings',

    /* Settings/Statistics/Index */
    'settings_statistics_index_page_title' => 'Statistics',
    'settings_statistics_index_page_description' => 'You can manage statistics options for your page.',
    'settings_statistics_index_analytics_view_id' => 'Google Analytics View ID',
    'settings_statistics_index_analytics' => 'Google Analytics Tracking ID',
    'settings_statistics_index_analytics_view_id_description' => 'Check documentation of <a href="https://github.com/spatie/laravel-analytics#how-to-obtain-the-credentials-to-communicate-with-google-analytics" target="_blank">spatie/laravel-analytics</a>',
    'settings_statistics_index_google_credentials' => 'Upload Google APIs credentials',
    'settings_statistics_index_google_credentials_exists' => 'storage\app\analytics\service-account-credentials.json exists.',
    'settings_statistics_index_google_credentials_doesnt_exists' => 'storage\app\analytics\service-account-credentials.json doesnt exists.',
    'settings_statistics_index_submit' => 'Save Settings',

    /* Settings/Statistics/Messages */
    'settings_statistics_messages_success' => 'Statistics settings has been saved successfully.',

    /* Settings/Translations */
    'settings_translations_page_title' => 'Translations',
    'settings_translations_page_description' => 'You can edit here files with translations.',
    'settings_translations_submit' => 'Save Settings',

    /* Settings/Users */
    'settings_users_index_page_title' => 'Administrators List',
    'settings_users_index_page_description' => 'You can manage all administrators.',
    'settings_users_index_add' => 'Add User',
    'settings_users_index_email' => 'E-mail address',
    'settings_users_index_created' => 'Created At',
    'settings_users_index_active' => 'Last Active',

    /* Settings/Users/Add */
    'settings_users_add_page_title' => 'Add User',
    'settings_users_add_page_description' => 'You can create a new user.',
    'settings_users_add_email' => 'E-mail address',
    'settings_users_add_password' => 'Password',
    'settings_users_add_repassword' => 'Retype Password',
    'settings_users_add_submit' => 'Add User',

    /* Settings/Users/Edit */
    'settings_users_edit_page_title' => 'Edit User',
    'settings_users_edit_page_description' => 'You can change password of selected user.',
    'settings_users_edit_email' => 'E-mail address',
    'settings_users_edit_password' => 'Password',
    'settings_users_edit_repassword' => 'Retype Password',
    'settings_users_edit_submit' => 'Edit User',

    /* Settings/Users/Messeges */
    'settings_users_msg_added' => 'User has been created successfully.',
    'settings_users_msg_updated' => 'Selected user has been updated successfully.',
    'settings_users_msg_removed' => 'Selected user has been successfully removed.',

    /* Settings/Locales */
    'settings_locales_page_title' => 'Locales',
    'settings_locales_page_description' => 'You can manage all your locales.',
    'settings_locales_add' => 'Add Locale',
    'settings_locales_name' => 'Name',
    'settings_locales_language' => 'Language',
    
    /* Settings/Locale-Edit */
    'settings_locale_edit_page_title' => 'Edit Locale',
    'settings_locale_edit_page_description' => 'You can edit your locale.',
    'settings_locale_edit_name' => 'Language Name',
    'settings_locale_edit_code' => 'Language Code',
    'settings_locale_edit_submit' => 'Edit Locale',
    
    /* Settings/Locale-Add */
    'settings_locale_add_page_title' => 'Add Locale',
    'settings_locale_add_page_description' => 'You can add here a new locale.',
    'settings_locale_add_name' => 'Language Name',
    'settings_locale_add_code' => 'Language Code',
    'settings_locale_add_submit' => 'Add Locale',
    
    /* Settings/Locale-Messages */
    'settings_locale_msg_added' => 'Your new locale has been successfully added.',
    'settings_locale_msg_updated' => 'Your locale has been successfully updated.',
    'settings_locale_msg_removed' => 'Selected locale has been successfully removed.',

    /* Messages */
    'msg_select_language' => 'Select at least one language.',
    
    /**
     * 
     * JavaScript Translations
     * 
     */
    
    //'js_' => '',
    
    /**
     * 
     * Dynamic Pages Translations
     * 
     */
    
    /* Page Html */
    'page_html_content' => 'Content',
    'page_html_view' => 'View',
    'page_html_view_1' => 'One Column View',
    'page_html_view_2' => 'Two Columns View',
    'page_html_view_3' => 'Three Columns View',
    
    /* Page Contact */
    'page_contact_display' => 'Display',
    'page_contact_display_all' => 'Show all contacts',
];
