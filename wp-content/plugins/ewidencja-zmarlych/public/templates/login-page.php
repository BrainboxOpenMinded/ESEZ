<?php 
get_header(); ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header login-header"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/eSEZ-medium.svg" class="text-center my-4 login-img-logo" /></div>
                                    <div class="card-body">
                                    <?php 
                                        $args = array(
                                            'echo'           => true,
                                            'redirect'       => 'https://esez.pl/konto',
                                            'label_log_in'   => __( 'Zaloguj się' ),
                                            'form_id'        => 'seminar-login',
                                            'label_username' => __( 'Login' ),
                                            'label_password' => __( 'Hasło' ),
                                            'label_remember' => __( 'Zapamiętaj mnie' ),
                                            'id_username'    => 'user_login',
                                            'id_password'    => 'user_pass',
                                            'id_submit'      => 'wp-submit',
                                            'remember'       => true,
                                            'value_username' => NULL,
                                            'value_remember' => true
                                        );
                                        wp_login_form($args);
                                    ?>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="/reset/">Zapomniałeś hasła?</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
			<?php get_footer(); ?>
