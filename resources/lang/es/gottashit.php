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
    'welcome' => "Estás en Gotta Shit. Empieza a evaluar baños a tu alrededor cuando te <a class='disclaimer-link' href=':path'>Registres</a>",
    'footer_year' => '2015',
    'no_geolocation' => 'Este navegador no soporta geolocalización.',
    'home' => '
        <p>¡Estás en Gotta Shit!</p>

        <p>¿Tienes que cagar?<br/>Este es el sitio web para ti.</p>

        <p>Aquí podrás:</p>

        <ul>
            <li>Buscar y encontrar los mejores sitios para cagar cerca</li>
            <li>Ver la puntuación de ese lugar</li>
            <li>Ver las opiniones de otros usuarios</li>
        </ul>

        <p>Una vez te hayas registrado serás capaz de...</p>

        <ul>
            <li>Añadir nuevos sitios para cagar</li>
            <li>Opinar sobre ese sitio u otros</li>
            <li>Puntuar los baños</li>
        </ul>

        <p>¡Regístrate y disfruta!</p>
    ',

    'email' => [
        'confirm_email_subject' => 'Confirma tu correo electrónico para GottaShit.com',
        'confirm_email_new_subject' => 'Confirma tu nueva dirección de correo electrónico para GottaShit.com',
        'reset_password_subject' => 'Resetea tu clave para GottaShit.com',
        'confirm_email_thanks'  => '¡Gracias por formar parte de GottaShit.com!',
        'confirm_email_action' => "Un último paso. Necesitamos que <a href=':path'>confirmes tu dirección de correo electrónico</a>.",
        'reset_password_thanks' => 'Nos has pedido resetear tu clave',
        'reset_password_action' => "<a href=':path'>Haz click aquí</a> para resetear tu clave: <a href=':path'>Resetear mi clave</a>",
    ],

    'nav' => [
        'login' => 'Entra',
        'logout' => 'Desconecta',
        'register' => 'Regístrate',
        'add_place' => 'Añadir',
        'user_places' => 'Tus sitios',
        'all' => 'Todos',
        'nearest' => 'Cercanos',
        'best_places' => 'Mejores Sitios',
        'profile' => 'Perfil',
    ],

    'user' => [
        'login' => 'Entra',
        'logout' => 'Desconecta',
        'register' => 'Regístrate',
        'email' => 'Correo Electrónico',
        'password' => 'Clave',
        'remember_me' => 'Recúerdame',
        'full_name' => 'Nombre completo',
        'username' => 'Nombre de usuario',
        'confirm_password' => 'Confirma tu clave',
        'delete_user' => 'Borrar Usuario',
        'edit_user' => 'Editar Usuario',
        'sent_password_reset' => 'Mandar Enlace de Resetea de Clave',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'reset_password' => 'Resetea tu clave',

        'update_user' => 'Actualizar usuario',
        'updated_user' => ':user actualizado',
        'edit_user_not_allowed' => 'No puedes editar ese usuario',
        'update_user_not_allowed' => 'No puedes actualizar ese usuario',
        'number_of_places' => 'Cantidad de lugares',
        'number_of_places_deleted' => 'Cantidad de lugares borrados',
        'number_of_places_rated' => 'Cantidad de lugares votados',

    ],

    'place' => [
        'name' => 'Nombre',
        'my_location' => 'Localización actual',
        'latitude' => 'Latitud',
        'longitude' => 'Longitud',
        'create_place' => 'Crear Sitio',
        'edit_place' => 'Editar Sitio',
        'update_place' => 'Actualizar Sitio',
        'delete_place' => 'Borrar Sitio',
        'delete_place_permanently' => 'Borrar Sitio Permanentemente',
        'created_place' => ':place Creado',
        'updated_place' => ':place Actualizado',
        'deleted_place' => ':place Borrado',
        'deleted_place_permanently' => ':place Borrado Permanentemente',
        'edit_place_not_allowed' => 'No puedes editar :place',
        'update_place_not_allowed' => 'No puedes actualizar :place',
        'delete_place_not_allowed' => 'No puedes borrar :place',
    ],

    'comment' => [
        'comments' => '{0} No hay comentarios. Anímate.|{1} :number_of_comments Comentario|[2,Inf] :number_of_comments Comentarios',
        'create_comment_label' => 'Deja un comentario',
        'create_comment' => 'Enviar comentario',
        'edit_comment' => 'Editar comentario',
        'update_comment_label' => 'Actualiza tu comentario',
        'update_comment' => 'Actualizar comentario',
        'delete_comment' => 'Borrar comentario',
        'created_comment' => ':place comentado',
        'updated_comment' => 'Comentario para :place Actualizado',
        'deleted_comment' => 'Comentario para :place Borrado',
        'edit_comment_not_allowed' => 'No puedes editar el comentario para :place',
        'update_comment_not_allowed' => 'No puedes actualizar el comentario para :place',
        'delete_comment_not_allowed' => 'No puedes borrar el comentario para :place',
    ],

    'star' => [
        'stars' => 'Puntos',
        'votes' => 'Votos',
        'rate_place' => 'Puntúalo',
        'rated' => ':place Puntuado',
        'delete_star' => 'Borrar Puntuación',
        'deleted_star' => 'Puntuación para :place borrada',
    ],

    'exception' => [
        '503' => 'Tenemos un pequeño problema',
        '404' => "Perdona, no podemos encontrar eso.",
        'token' => 'Inténtalo de nuevo',
    ],

];
