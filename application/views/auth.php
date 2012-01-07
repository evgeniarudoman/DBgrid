    <body>
        <script>
            
            
            $(document).ready(function(){
                
                $("#form").validate({
 
                    rules: {
                        first_name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email:true
                        },
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
                        first_name: "<img src='/image/warning.png'>This field is required",
                        email: {
                            required: "<img src='/image/warning.png'>This field is required",
                            email: "<img src='/image/warning.png'>Please enter a valid email"
                        },
                        username:  {
                            required: "<img src='/image/warning.png'>This field is required",
                            minlength:"<img src='/image/warning.png'>Please enter at least 6 characters.",
                            maxlength:"<img src='/image/warning.png'>Please enter no more than 12 characters."
                        },
                        password:{
                            required: "<img src='/image/warning.png'>This field is required",
                            minlength:"<img src='/image/warning.png'>Please enter at least 6 characters.",
                            maxlength:"<img src='/image/warning.png'>Please enter no more than 12 characters."
                        },
                        confirm_password:{
                            required: "<img src='/image/warning.png'>This field is required",
                            equalTo: "<img src='/image/warning.png'>Please re-enter your password",
                            minlength:"<img src='/image/warning.png'>Please enter at least 6 characters.",
                            maxlength:"<img src='/image/warning.png'>Please enter no more than 12 characters."
                        }                       
                    }
                });
              
            });
            
            
        </script>
        <table id="auth" >
            <tr>
                <td>
                    <form id="form" action="" method="post">
                        <table >
                            <tr>
                                <td><span>First name <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="first_name" class="val"/></td>
                            </tr>
                            <tr>
                                <td><span>E-mail <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="email" class="val"/></td>
                            </tr>
                            <tr>
                                <td><span>Username <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="username" class="val"/></td>
                            </tr>
                            <tr>
                                <td><span>Password <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="password" class="val" id="password"/></td>
                            </tr>
                            <tr>
                                <td><span>Confirm password <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="confirm_password" class="val"/></td>
                            </tr>

                            <tr>
                                <td><input type="submit" name="regist" value="REGISTER" class="button"/></td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td>
                    <div id="right">
                        <span>Registration</span><br/><br/>                        
                        If you are already have an account, <br/>
                        please <a href="/grid/login">SIGN IN</a><br/><br/>

                    </div>
                </td>
            </tr>
        </table>

    </body>
</html>