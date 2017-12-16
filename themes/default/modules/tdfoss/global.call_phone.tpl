<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/tdfoss.css" />
<div class="phone-icon">
    <a href="tel:{CONFIG.phone}"><img src="{CONFIG.phone_icon}" /></a>
</div>
<!-- END: main -->

<!-- BEGIN: config -->
<tr>
    <td>{LANG.phone}</td>
    <td><input type="text" name="config_phone" class="form-control" value="{DATA.phone}"></td>
</tr>
<tr>
    <td>{LANG.phone_icon}</td>
    <td><div class="input-group">
            <input class="form-control" type="text" name="config_phone_icon" value="{DATA.phone_icon}" id="image" /> <span class="input-group-btn">
                <button class="btn btn-default selectfile" type="button">
                    <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
                </button>
            </span>
        </div></td>
</tr>
<script>
    $(".selectfile").click(function() {
        var area = "image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURRENT_PATH}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
</script>
<!-- END: config -->