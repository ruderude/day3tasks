<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">モーダルヘッダー</div>
        </v-app-bar>
        
        <v-main>
            <v-container>
                <div class="text-h6 mx-auto">モーダルメイン</div>
            </v-container>
        </v-main>
        
        <v-footer>
        </v-footer>
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
