<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gotta Shit
    |--------------------------------------------------------------------------
    |
    | Text for Gotta Shit
    |
    */

    'site_name' => 'Gotta Shit',
    'welcome' => "Welcome to Gotta Shit. You can start to evaluate the WC in your around when you <a class='disclaimer-link' href=':path'>Register</a>",
    'footer_year' => '2015',
    'no_geolocation' => 'Geolocation is not supported by this browser.',
    'home' => '
        <p>Welcome to Gotta Shit!</p>

        <p>Have you got to take a shit? <br/>This is the right website for you.</p>

        <p>Here you can:</p>

        <ul>
            <li>Search and find the best sites to poo close to you</li>
            <li>Check the shitty ratings of the spot</li>
            <li>View opinions from other users</li>
        </ul>

        <p>Once you sign up you will be able to...</p>

        <ul>
            <li>Add new places to take a shit</li>
            <li>Express yourself about the place</li>
            <li>Rate toilets and comment on them</li>
        </ul>

        <p>Register now and join us!</p>
    ',

    'email' => [
        'confirm_email_subject' => 'Confirm your email for GottaShit.com',
        'confirm_email_new_subject' => 'Confirm your new email for GottaShit.com',
        'reset_password_subject' => 'Reset your password for GottaShit.com',
        'confirm_email_thanks'  => 'Thanks for signing up!',
        'confirm_email_action' => "We just need you to <a href=':path'>confirm your email address</a> real quick!",
        'reset_password_thanks' => 'You can restart your password',
        'reset_password_action' => "<a href=':path'>Click here</a> to reset your password: <a href=':path'>Reset your password</a>",
        'new_place_add' => 'New place Added',
        'new_place_action' => "<a href=':path'>Click here</a> to view new place: <a href=':path'>:place</a> created by <a href=':path_user'>:username</a>",
        'new_comment_add' => 'New comment added for :place',
        'new_comment_action' => "<a href=':path'>Click here</a> to view new comment for <a href=':path'>:place</a> created by <a href=':path_author_of_comment'>:username_author_of_comment</a>",
        'new_contact_form' => "New contact sended from web",
    ],

    'nav' => [
        'login' => 'Login',
        'logout' => 'Logout',
        'register' => 'Register',
        'add_place' => 'Add',
        'user_places' => 'Your places',
        'all' => 'All',
        'nearest' => 'Nearest',
        'best_places' => 'Best Places',
        'profile' => 'Profile',
        'es' => 'ES',
        'en' => 'EN',
        'menu' => 'Menu',
        'menu_user' => 'User menu',
    ],

    'title' => [
        'create_place' => 'Add a Place for shit',
        'edit_place' => 'Edit :place',
        'user_places' => 'Your Places',
        'best_places' => 'Best Places',
        'nearest_places' => 'Nearest Places',
        'all_places' => 'All Places',
        'welcome' => 'Welcome and enjoy it',
        'register' => 'Register',
        'login' => 'Login',
        'edit_user' => 'Edit :user',
        'user_profile' => ':user profile',
    ],

    'user' => [
        'login' => 'Login',
        'login_facebook' => 'Login with Facebook',
        'login_twitter' => 'Login with Twitter',
        'login_github' => 'Login with Github',
        'add_facebook' => 'Add your Facebook',
        'add_twitter' => 'Add your Twitter',
        'add_github' => 'Add your Github',
        'logout' => 'Logout',
        'register' => 'Register',
        'email' => 'Email',
        'password' => 'Password',
        'remember_me' => 'Remember me',
        'full_name' => 'Full name',
        'username' => 'Username',
        'confirm_password' => 'Confirm password',
        'delete_user' => 'Delete User',
        'edit_user' => 'Edit User',
        'sent_password_reset' => 'Send Password Reset Link',
        'forgot_password' => 'Forgot your password?',
        'reset_password' => 'Reset password',
        'update_user' => 'Update user',
        'updated_user' => ':user updated',
        'edit_user_not_allowed' => 'You are not allowed for edit this user',
        'update_user_not_allowed' => 'You are not allowed for update this user',
        'number_of_places' => 'Number of places',
        'number_of_places_deleted' => 'Number of places deleted',
        'number_of_places_rated' => 'Number of places rated',
        'no_notifications_warning' => 'You will not receive more email notifications until confirm or defined your email',
    ],

    'place' => [
        'name' => 'Name',
        'my_location' => 'Get my current location',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'create_place' => 'Create Place',
        'edit_place' => 'Edit Place',
        'update_place' => 'Update Place',
        'delete_place' => 'Delete Place',
        'delete_place_confirm' => 'Are you sure?',
        'delete_place_permanently' => 'Delete Place Permanently',
        'restore_place' => 'Restore Place',
        'created_place' => ':place Created',
        'updated_place' => ':place Updated',
        'deleted_place' => ':place Deleted',
        'restored_place' => ':place Restored',
        'deleted_place_permanently' => ':place Deleted Permanently',
        'edit_place_not_allowed' => 'You are not allowed for edit :place',
        'update_place_not_allowed' => 'You are not allowed for update :place',
        'delete_place_not_allowed' => 'You are not allowed for delete :place',
        'restore_place_not_allowed' => 'You are not allowed for restore :place',
    ],

    'comment' => [
        'comments' => '{0} No comments. Be first in comment|{1} :number_of_comments Comment|[2,*] :number_of_comments Comments',
        'create_comment_label' => 'Leave a comment',
        'create_comment' => 'Send comment',
        'edit_comment' => 'Edit comment',
        'update_comment_label' => 'Update your comment',
        'update_comment' => 'Update comment',
        'delete_comment' => 'Delete comment',
        'delete_comment_confirm' => 'Delete comment permanently',
        'created_comment' => ':place commented',
        'updated_comment' => 'Comment for :place updated',
        'deleted_comment' => 'Comment for :place Deleted',
        'edit_comment_not_allowed' => 'You are not allowed for edit this comment for :place',
        'update_comment_not_allowed' => 'You are not allowed for update this comment for :place',
        'delete_comment_not_allowed' => 'You are not allowed for delete this comment for :place',
    ],

    'star' => [
        'stars' => 'Stars',
        'votes' => 'Votes',
        'rate_place' => 'Rate this',
        'rated' => ':place Rated',
        'delete_star' => 'Delete rate',
        'deleted_star' => 'Rate for :place deleted',
    ],

    'subscription' => [
        'add' => 'I want subscribe to this place',
        'delete' => 'I want unsubscribe to this place',
        'subscribed_place' => 'You will receive emails when someone comment this place',
        'unsubscribed_place' => 'You will not receive emails when someone comment this place',
    ],

    'contact_form' => [
        'email' => 'email',
        'subject' => 'subject',
        'body' => 'message',
        'send' => 'send contact',
    ],

    'exception' => [
        '503' => 'We have a litle problem',
        '404' => "Sorry, I can't find it",
        'token' => 'Try again',
    ],

];
