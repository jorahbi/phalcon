{% extends "layouts/main.volt" %}

{% block content %}
<el-button @click="visible = true">Button</el-button>
<el-dialog :visible.sync="visible" title="Hello world">
    <p>Try Element</p>
</el-dialog>
{% endblock %}

{% block script %}
<script>
    new Vue({
        delimiters: ['${', '}'],
        el: '#app',
        data: function () {
            return {visible: false}
        }
    })
</script>
{% endblock %}