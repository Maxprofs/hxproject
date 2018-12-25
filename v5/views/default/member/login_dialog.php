{if strpos(Common::get_current_url(),'/member/')===false}
    {Common::js('jquery.md5.js')}
{/if}
{if strpos(Common::get_current_url(),'book')===false}
    {Common::js('jquery.validate.js')}
{/if}
{include "member/login_fast"}
<script>
    function showDialogLogin() {
        if($('#is_login_order').length==1) {
            $('#is_login_order').removeClass('hide');
        }
    }
</script>