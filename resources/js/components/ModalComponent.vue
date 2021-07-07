<template>
    <v-app>
        <v-container>
            <div class="text-h6 mx-auto">モーダルメイン</div>
        </v-container>
    </v-app>
</template>

<script>
import Vue from 'vue'
import Bugsnag from '@bugsnag/js'
import BugsnagPluginVue from '@bugsnag/plugin-vue'

Bugsnag.start({
    apiKey: 'd96162df63a8803bcee425928dcd0f36',
    plugins: [new BugsnagPluginVue()]
})

const bugsnagVue = Bugsnag.getPlugin('vue')
bugsnagVue.installVueErrorHandler(Vue)

export default {
    name: "Modal",
    data () {
        return {

        }
    },
    computed: {

    },
    methods: {
        hello: function() {
            console.log('hello hello')
        },
    },
    created : function(){
        console.log('created')
        },
    mounted : function(){
        console.log('mounted')
    }
}
</script>
