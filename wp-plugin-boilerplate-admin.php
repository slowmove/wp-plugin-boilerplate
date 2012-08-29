<?php
add_action('network_admin_menu', 'Custom_create_menu');
add_action('admin_menu', 'Custom_create_menu');

function Custom_create_menu() 
{
    add_menu_page('Custom Plugin Admin', 'Custom Plugin Admin', 'manage_options', dirname(__file__), 'Custom_admin_page');
    //add_submenu_page(dirname(__file__), 'Arkiverade chattar', 'Arkiverade chattar', 'expertchat_options', 'twentyfourExpertChat_archive', 'twentyfourExpertChat_archive_page');
    //add_submenu_page(dirname(__file__), 'Hantera chattar', 'Hantera chattar', 'expertchat_options_handle', 'twentyfourExpertChat_new', 'twentyfourExpertChat_new_page');
    //
    //wp_enqueue_style('ExpertChatAdminCss');
    //wp_enqueue_script('jquery'); 
    //wp_enqueue_script('ExpertChatModal');
    //wp_enqueue_script('Placeholder');      
}

function Custom_admin_page() 
{
    $pluginRoot = plugins_url('', __FILE__);   
	?>
    <div class="wrap">
        <h2>Fix HCM Sites</h2>
        <div class="innerWrapper">
            <table id="mailList">
                <thead>
                    <tr>
                        <th>Fix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Skapa Expertchatt som draft på varje sajt
                        </td>
                        <td>
                            <input type="button" value="Skapa" onclick="create_chat();" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Skapa Kontakta Oss på varje sajt
                        </td>
                        <td>
                            <input type="button" value="Skapa" onclick="create_contact_form();" />
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            Sätt default-uppsättning av widgets
                        </td>
                        <td>
                            <input type="button" value="Fixa" onclick="setup_default_widgets();" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ändra subject-fältet på kontaktformuläret
                        </td>
                        <td>
                            <input type="button" value="Shoot" onclick="change_form_subject();" />
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <script type="text/javascript">
            function create_chat()
            {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $pluginRoot ?>/api/create_chat.php",
                    data: {},
                    async: true,
                    timeout: 50000,
                    success: function(data) {
                        alert("Succé");
                    },
                    error: function(data) {
                        alert("Någonting gick fel");
                    }
                });	               
            }
            
            function create_contact_form()
            {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $pluginRoot ?>/api/create_contact_form.php",
                    data: {},
                    async: true,
                    timeout: 50000,
                    success: function(data) {
                        alert("Succé");
                    },
                    error: function(data) {
                        alert("Någonting gick fel");
                    }
                });	                
            }
            
            function setup_default_widgets()
            {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $pluginRoot ?>/api/set_default_widgets.php",
                    data: {},
                    async: true,
                    timeout: 50000,
                    success: function(data) {
                        alert("Succé");
                    },
                    error: function(data) {
                        alert("Någonting gick fel");
                    }
                });	                
            }
            
            function change_form_subject()
            {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $pluginRoot ?>/api/change_form.php",
                    data: {},
                    async: true,
                    timeout: 50000,
                    success: function(data) {
                        alert("Succé");
                    },
                    error: function(data) {
                        alert("Någonting gick fel");
                    }
                });	                  
            }
        </script>
    <?php 
}

?>