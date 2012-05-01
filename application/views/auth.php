<body>
    <script>
        $(document).ready(function(){
                
            $("#form").validate({
 
                rules: {
                    username: {
                        required: true,
                        minlength: 6,
                        maxlength: 12
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 12
                    },
                    confirm_password: {
                        required: true,
                        minlength: 6,
                        maxlength: 12,
                        equalTo: "#password"
                    }
                },
                messages: {
                    username:  {
                        required: '<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>This field is required.</span>',
                        minlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter at least 6 characters.</span>',
                        maxlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter no more than 12 characters.</span>'
                    },
                    password:{
                        required: '<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>This field is required.</span>',
                        minlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter at least 6 characters.</span>',
                        maxlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter no more than 12 characters.</span>'
                    },
                    confirm_password:{
                        required: '<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>This field is required.</span>',
                        equalTo:  '<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Passwords doesn\'t match.</span>',
                        minlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter at least 6 characters.</span>',
                        maxlength:'<span class="ui-state-error-text" style="font-size: 12px;color: #FF0084;font-style: italic;"><span class="ui-icon ui-icon-alert" style="margin-left: 303px;margin-top: -17px;"></span>Please enter no more than 12 characters.</span>'
                    }                       
                }
            });
        });
    </script>
    <table id="auth">
        <tr>
            <td>
                <form id="form" action="" method="post">
                    <table>
                        <tr>
                            <td>
                                <span style="font-size: 12px;color: #FF0084;font-style: italic;">
                                        <?php
                                        $error = $this->session->userdata ('error');
                                        if (isset ($error) && !empty ($error))
                                        {
                                            echo $error;
                                        }
                                        ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Имя пользователя <span class="star">*</span></span></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="username" class="val" value="<?php if (isset($_POST['username']) && !empty($_POST['username']))echo $_POST['username']?>"/></td>
                        </tr>
                        <tr>
                            <td><span>Пароль <span class="star">*</span></span></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" class="val" id="password"/></td>
                        </tr>
                        <tr>
                            <td><span>Подтверждение пароля <span class="star">*</span></span></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="confirm_password" class="val"/></td>
                        </tr>
                        <tr id="right">
                            <td class="little">Если у вас уже существует аккаунт, то <a href="/grid/login">войдите</a></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="regist" value="РЕГИСТРАЦИЯ" class="btn btn-primary"/></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>