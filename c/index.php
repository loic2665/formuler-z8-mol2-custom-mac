<?php

$portal = addslashes(htmlspecialchars($_GET["portal"]));
$port = addslashes(htmlspecialchars($_GET["port"]));
$mac = addslashes(htmlspecialchars($_GET["mac"]));

$fportal = fopen("../server/portal.txt", "w");
fwrite($fportal, $portal);
fclose($fportal);


$fport = fopen("../server/port.txt", "w");
fwrite($fport, $port);
fclose($fport);


$fmac = fopen("../server/mac.txt", "w");
fwrite($fmac, $mac);
fclose($fmac);


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <script type="text/javascript" src="../server/api/load_js.php"></script>
<title>stalker_portal</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--debug-->
<!--<script type="text/javascript" src="http://192.168.1.13:8000/target/target-script-min.js#azhurb"></script>-->

<script type="text/javascript" defer="defer">

var debug = 0;
var stb;
var _GET = {};
//var gmode = '';
var resolution_prefix = '';

var module = module || {};
var word = {};
var windowId;
var focus_module = '', referrer = '', single_module = [];

window.loadRequiredFiles(load_base);

function load_base(){
    //console.log('Loading load_base');
    window.onerror = function(msg, url, lno){
        _debug('line: '+lno+'; msg: "'+msg+'" url: '+url);
        return true;
    };
    get_params();

    if (_GET.hasOwnProperty('debug')){
        debug = 1;
    }

    if (_GET.hasOwnProperty('referrer')){
        referrer = decodeURIComponent(_GET['referrer']);
    }

    if (_GET.hasOwnProperty('single_module')){
        single_module = _GET['single_module'].split(',');
    }

    if (_GET && _GET.hasOwnProperty('focus_module')){
        focus_module = _GET['focus_module'];
    }
    init();
}
    /*window.onload = init;*/

var loader = {

    chain : [],
    cur_idx : -1,
    head : document.getElementsByTagName("head")[0],
    max_load_percent : 50,
    step : 0,
    template : 'default',
    paused : false,

    set_template : function(template){
        _debug('loader.set_template', template);
        this.template = template;
    },

    add : function(modules){
        _debug('loader.add');

        modules = modules || [];

        this.cur_idx = -1;

        for (var i=0; i<modules.length; i++){
            if (this.chain.indexOf(modules[i]) >= 0){
                modules.splice(i, 1);
            }
        }

        this.chain = modules;

        this.step = Math.ceil(this.max_load_percent/this.chain.length);

        this.next();
    },

    next : function(){
        _debug('loader.next');

        _debug('loader.paused', this.paused);

        if (this.paused){
            return;
        }

        if (this.cur_idx < this.chain.length-1){
            this.cur_idx++;
            this.append(this.chain[this.cur_idx]);
        }
    },

    append : function(module){
        _debug('loader.append');

        stb.loader.add_pos(this.step, 'append '+module);

        this.append_style(module);

        this.append_javascript(module);
    },

    append_style : function(module){
        _debug('loader.append_style', module);

        if (module.indexOf('external_') === 0){
            _debug('skip style loading', module);
            return;
        }

        var _style = document.createElement('link');
        _style.type = "text/css";
        _style.rel = "stylesheet";

        if (module.indexOf('supermodule') > 0){
            _style.href = module + resolution_prefix +".css&single_module="+single_module.join(',');
        }else{
            _style.href = 'template/' + this.template + '/' + module + resolution_prefix +".css";
        }

        this.head.appendChild(_style);
        _debug('append', _style.href);
    },

    append_javascript : function(module){
        _debug('loader.append_javascript', module);

        var _script = document.createElement('script');
        _script.type = "text/javascript";
        if (module.indexOf('supermodule') > 0){
            _script.src  = module + ".js&single_module="+single_module.join(',');
        }else{
            if (module.indexOf('external_') === 0){

                /*var idx = stb.all_modules.indexOf(module);

                if (idx !== -1){
                    stb.all_modules[idx] = module.replace('external_','');
                }*/

                _script.src  = '../server/api/ext_module.php?name='+module.replace('external_', '')+'&mac='+stb.mac;
            }else{
                _script.src  = module + ".js";
            }
        }

        _script.onerror = function() {
            _debug('Error loading script', _script.src);
            loader.next();
        };

        this.head.appendChild(_script);
        _debug('append', _script.src);
    },

    pause : function () {
        _debug('loader.pause');
        this.paused = true;
    },

    resume : function () {
        _debug('loader.resume');
        if (this.paused){
            this.paused = false;
            this.next();
        }
    }
};

/**
 * Init STB.
 */
function init(){
    _debug('init');

    if (typeof(gSTB) == 'undefined'){
        if (window.innerWidth > 720){
            resolution_prefix = '_720';
        }else if (window.innerHeight < 576){
            resolution_prefix = '_480';
        }else{
            resolution_prefix = '';
        }
    }else{
        stb.resize_window();
    }

    if (typeof(stbWebWindow) != 'undefined'){
        windowId = stbWebWindow.windowId();
    }

    _debug('windowId', windowId);

    if (_GET && _GET.hasOwnProperty('access_token')){
        stb.access_token = _GET['access_token'];
    }

    _debug('_GET', _GET);

    /*if (typeof(gSTB) != 'undefined'){
        if (gSTB.RDir('gmode') != 720){
            gmode = '720';
        }
    }else{
        if (window.innerWidth > 720){
            gmode = '720';
        }
    }

    if (gmode){
        img_prefix = '_'+gmode;
    }

    window.moveTo(0, 0);
    
    if (gmode == '720'){
        window.resizeTo(1280, 720);
    }else{
        window.resizeTo(720, 576);
    }*/
    
    stb.loader = new load_bar();
    stb.loader.bind();
    stb.loader.stop();
    
    stb.loader.set_callback(
        function(){
            stb.post_loading_handle();
        }
    );
    
    stb.init();
    
    (function(){
        
        if (stb.player.on){
            
            if (stb.player.con_menu && stb.player.con_menu.on){
                stb.player.con_menu.hide();
            }

            if(single_module.length){
                if (stb.player.on){
                    stb.player.show_prev_layer();
                }
                return;
            }
            
            stb.player.prev_layer && stb.player.prev_layer.hide && stb.player.prev_layer.hide();

            if (stb.player.on){
                stb.player.stop();
            }

            main_menu.show();
        }
        
    }).bind(key.MENU);
    
    (function(){

        _debug('stb.cur_single_module', stb.cur_single_module);

        if (single_module.length && (single_module.indexOf('tv') == -1 || stb.cur_single_module != 'tv')){
            return;
        }

        if (!stb.player.channels || stb.player.channels.length == 0){
            return;

        }

        stb.cur_layer && stb.cur_layer.hide && stb.cur_layer.hide();

        if (module && module.tv){
            stb.set_cur_place(module.tv.layer_name);
            stb.set_cur_layer(module.tv);
        }

        if (!module.blocking.on){
            stb.player.play_last();
        }
        
    }).bind(key.TV);

    (function(){
        if (module.radio && !module.radio.on){

            keydown_observer.emulate_key(key.MENU);

            main_menu.hide();
            module.radio.show();
            module.radio.cur_view = 'short';

            module.radio.shift_row_callback = function(){
                module.radio.play();
                module.radio.shift_row_callback = null;
                module.radio.cur_view = 'wide';
            };
        }
    }).bind(key.AUDIO);

    (function(){
        
        stb.switchPower();
        
    }).bind(key.POWER);

    /* END LAYER MANAGEMENT */
    
}

</script>

</head>
<body>
<!--<img src="i/loading_bg.gif" width="0" height="0"/>
<img src="i/loading.png" width="0" height="0"/>-->
</body>
</html>