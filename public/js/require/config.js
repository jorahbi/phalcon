
var requireConfig = {
    baseUrl: "/js/",
    packages: [{
     name: 'Data',
     location: 'data',
     main: 'Data'
     }],
    paths: {
        vue: 'vue',
        axios: 'vue/axios'
    },
    shim:{
        underscore: {
            //exports: 'axios'
        },
        vue: {
            deps: [
                'axios',
                'vue/vuex',
            ]
        }
        /*icheck: {
            deps: [
                'css!global/plugins.css',
                'css!plugins/icheck/skins/minimal/_all.css',
                'plugins/icheck/icheck.min'
            ]
        }*/
    },
    map: {
        '*': {
            'css': '/require/css.js',
            'text': '/require/text.js'
        }
    },
    urlArgs: "t=" + (new Date()).getTime()
};
/*String.prototype.trim=function(char){
    char = char || '';
    var reg = new RegExp('/(^\s+)|(^' + char + '?)|(\s+$)|(' + char + '?$)/g');
    return this.replace(reg,'')
}*/
requirejs.config(requireConfig);


