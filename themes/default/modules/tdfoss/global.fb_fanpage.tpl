<!-- BEGIN: main -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-page" data-href="{DATA.href}" data-tabs="{DATA.tabs}" data-small-header="{DATA.small_header}" data-adapt-container-width="{DATA.container_width}" data-hide-cover="{DATA.hide_cover}" data-show-facepile="{DATA.show_facepile}"><blockquote cite="{DATA.href}" class="fb-xfbml-parse-ignore"><a href="{DATA.href}">{DATA.name}</a></blockquote></div>
<!-- END: main -->

<!-- BEGIN: config -->
<tr>
    <td>{LANG.name}</td>
    <td><input type="text" name="config_name" class="form-control" value="{DATA.name}"></td>
</tr>
<tr>
    <td>{LANG.href}</td>
    <td><input type="url" name="config_href" class="form-control" value="{DATA.href}"></td>
</tr>
<tr>
    <td>{LANG.tabs}</td>
    <td>
        <!-- BEGIN: tabs -->
        <label><input type="checkbox" name="config_tabs[]" value="{TABS.index}"{TABS.checked}>{TABS.index}</label>
        <!-- END: tabs -->    
    </td>
</tr>
<tr>
    <td>{LANG.width}</td>
    <td><input type="text" name="config_width" class="form-control" value="{DATA.width}"></td>
</tr>
<tr>
    <td>{LANG.height}</td>
    <td><input type="text" name="config_height" class="form-control" value="{DATA.height}"></td>
</tr>
<tr>
    <td>{LANG.small_header}</td>
    <td><input type="checkbox" name="config_small_header" class="form-control" value="1" {DATA.ck_small_header}></td>
</tr>
<tr>
    <td>{LANG.container_width}</td>
    <td><input type="checkbox" name="config_container_width" class="form-control" value="1" {DATA.ck_container_width}></td>
</tr>
<tr>
    <td>{LANG.hide_cover}</td>
    <td><input type="checkbox" name="config_hide_cover" class="form-control" value="1" {DATA.ck_hide_cover}></td>
</tr>
<tr>
    <td>{LANG.show_facepile}</td>
    <td><input type="checkbox" name="config_show_facepile" class="form-control" value="1" {DATA.ck_show_facepile}></td>
</tr>
<!-- END: config -->