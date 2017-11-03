{{ form("/passport/index/checkLogin", "method": "post", "class": "test tst1", "id": "login") }}
    <fieldset>
        <div>
            <label for="email">
                Username/Email
            </label>

            <div>
                {{ text_field("email") }}
            </div>
        </div>

        <div>
            <label for="password">
                Password
            </label>

            <div>
                {{ password_field("password") }}
            </div>
        </div>
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />
        <div>
            {{ submit_button("Login") }}
        </div>
    </fieldset>
{{ endForm() }}
<script type="text/javascript">
	require(['axios', 'vue', 'require'], function(Axios, Vue, Require){

        /*Axios.post('/passport/index/checkLogin', $('#login').serialize()).
        then(function(response){
            if (!response.data.token)
                return true;

            
        }).
        catch(function(error){

        });*/
        
	});
</script>