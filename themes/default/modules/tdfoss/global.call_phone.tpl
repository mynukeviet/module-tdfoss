<!-- BEGIN: main -->
<style>
.sonar-wrapper {
    z-index: 99999;
    opacity: 0.5;
    position: fixed;
    bottom: {CONFIG.position_x}px;
    {CONFIG.position}: {CONFIG.position_y}px;
}

/* The circle */
.sonar-emitter {
    position: relative;
    margin: 32px auto;
    width: 100px;
    height: 100px;
    border-radius: 9999px;
    background-color: #E71C1C;
}

/* the 'wave', same shape and size as its parent */
.sonar-wave {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 9999px;
    background-color: #E71C1C;
    opacity: 0;
    z-index: -1;
    pointer-events: none;
}

.sonar-emitter a {
    font-size: 40px;
    margin: 34px;
    color: white;
    font-weight: 800;
}

/*
  Animate!
  NOTE: add browser prefixes where needed.
*/
.sonar-wave {
    animation: sonarWave 2s linear infinite;
}

@keyframes sonarWave {
  from {
    opacity: 0.4;
  }
  to {
    transform: scale(3);
    opacity: 0;
  }
}
</style>

<div class="sonar-wrapper">
    <div class="sonar-emitter">
        <div class="sonar-wave">          
        </div>
        <a href="tel:{CONFIG.phone}" class="fa fa-phone"></a>
    </div>
</div>
<!-- END: main -->

<!-- BEGIN: config -->
<tr>
    <td>{LANG.phone}</td>
    <td><input type="text" name="config_phone" class="form-control" value="{DATA.phone}"></td>
</tr>
<tr>
    <td>{LANG.position}</td>
    <td>
        <!-- BEGIN: position -->
        <label><input type="radio" name="config_position" value="{POSITION.index}" {POSITION.checked}>{POSITION.value}</label>
        <!-- END: position -->
    </td>
</tr>
<tr>
    <td>{LANG.position_x}</td>
    <td><input type="text" name="config_position_x" class="form-control" value="{DATA.position_x}"></td>
</tr>
<tr>
    <td>{LANG.position_x}</td>
    <td><input type="text" name="config_position_y" class="form-control" value="{DATA.position_y}"></td>
</tr>
<!-- END: config -->