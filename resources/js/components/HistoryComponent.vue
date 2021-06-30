<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">タスクの履歴q</div>
        </v-app-bar>
        
        <v-main>
            <v-container>
                <v-card>
                    <v-list dense>
                        <v-list-group
                            v-for="item in items"
                            :key="item.title"
                            v-model="item.active"
                            :prepend-icon="item.action"
                            color="orange lighten-1"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                            v-for="child in item.items"
                            :key="child.title"
                            >
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-card>
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
    data () {
        return {
            items: [
                {
                action: 'mdi-arrow-right-circle',
                items: [{ title: 'List Item' }],
                title: '2021-06-25',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [
                    { title: 'Breakfast & brunch' },
                    { title: 'New American' },
                    { title: 'Sushi' },
                ],
                title: '2021-06-24',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [{ title: 'List Item' }],
                title: '2021-06-23',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [
                    { title: 'Breakfast & brunch' },
                    { title: 'New American' },
                    { title: 'Sushi' },
                ],
                title: '2021-06-22',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [{ title: 'List Item' }],
                title: '2021-06-21',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [{ title: 'List Item' }],
                title: '2021-06-20',
                },
                {
                action: 'mdi-arrow-right-circle',
                items: [{ title: 'List Item' }],
                title: '2021-06-19',
                },
            ],
        }
    },
    computed: {

    },
    methods: {
        hello: function() {
            console.log('hello hello')
        }
    },
    created : function(){
        console.log('created')
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
        axios.post('/v1/liff/getAccessToken', {
            text: 'ヒストリーテストだよー'
        })
            .then(response => {
                console.log('送信したテキスト: ' + response.data.text);
            }).catch(error => {
                console.log(error);
            });
        },
    mounted : function(){
        console.log('mounted')
    }
}
</script>
