<template>
    <v-app>
        <v-container class="mt-12">
            <v-dialog v-model="dialog" width=500>
                <v-card>
                    <v-card-title>{{ task.title }}</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-sheet class="pa-3">
                        <div class="body-1">{{ task.detail }}</div>
                        </v-sheet>
                    </v-card-text>
                    <button @click="$emit('close')">閉じる</button>
                </v-card>
            </v-dialog>
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
    props: {
        task: {
        },
    },
    data () {
        return {
            dialog: false,
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
