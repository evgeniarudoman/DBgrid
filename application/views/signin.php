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
                    }        
                }
            });
        });
    </script>
    <table id="login">
        <tr>
            <td>
                <form id="form" action="" method="post">
                    <table >
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
                            <td><input type="password" name="password" class="val"/></td>
                        </tr>
                        <tr id="right">
                            <td class="little" style="width:200px">Если вы не зарегистрированный пользователь, то <a href="/grid/register">зарегистрируйтесь</a></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="signin" value="ВОЙТИ" class="btn btn-primary"/></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>