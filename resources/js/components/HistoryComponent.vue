<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">タスクの履歴</div>
        </v-app-bar>
        
        <v-main>
            <v-container>
                <v-card>
                    <v-list dense>
                        <v-list-group
                            v-for="(value, key, index) in tasks"
                            :key="value.title"
                            :prepend-icon="'mdi-arrow-right-circle'"
                            color="orange lighten-1"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="key"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                        </v-list-group>
                    </v-list>
                    <v-btn @click="getAccess()">GET</v-btn>
                    <v-btn @click="postAccess()">POST</v-btn>
                </v-card>
                <div id="liff_id">LIFF ID：{{ liffId }}</div>
                <div id="line_id">LINE ID：{{ lineId }}</div>
                <div id="access_token">access_token：{{ accessToken }}</div>
                <div id="tasks">tasks：{{ tasks }}</div>
                <div id="error">error：{{ error }}</div>
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
import liff from "@line/liff";

Bugsnag.start({
    apiKey: 'd96162df63a8803bcee425928dcd0f36',
    plugins: [new BugsnagPluginVue()]
})

const bugsnagVue = Bugsnag.getPlugin('vue')
bugsnagVue.installVueErrorHandler(Vue)

axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "History",
    props: {
        liffId: {
            type: String,
            required: true
        }
    },
    data () {
        return {
            liffId: null,
            lineId: null,
            accessToken: null,
            tasks: [],
            error: null,
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
        },
        getAccess: function() {
            console.log('GET')
            axios.get('getAccessToken?text=テキストテスト')
                .then(response => {
                    console.log('送信したテキスト: ' + response.data.message);
                }).catch(error => {
                    console.log(error);
                });

        },
        postAccess: function() {
            console.log('POST')
            axios.post('getAccessToken', {
                text: 'postヒストリーテストだよー'
            })
                .then(response => {
                    console.log('送信したテキスト: ' + response.data.message);
                }).catch(error => {
                    console.log(error);
                });
        }
    },
    created : function(){
        console.log('created')

        },
    mounted: function() {
        // this.overlay = true
        liff.init({
            liffId: this.liffId
        })
            .then(() => {
                this.accessToken = liff.getAccessToken()
                // Bugsnag.notify(new Error(this.accessToken))
                axios.post("/oldTasks", {
                        access_token: this.accessToken
                    })
                    .then(response => {
                        // Bugsnag.notify(new Error(response.data))
                        // タスクセット
                        const tasks = response.data
                        this.tasks = tasks
                        // if (tasks.length <= 0) {
                        //     this.taskInit()
                        // } else {
                        //     this.setTasks(tasks)
                        // }
                        // this.overlay = false
                    })
                    .catch(err => {
                        // console.log(err);
                        this.error = err
                        // this.overlay = false
                        Bugsnag.notify(new Error("/v1/liff/setTasks error"));
                    });
            })
            .catch(err => {
                this.error = err
                // this.overlay = false
                Bugsnag.notify(new Error(err))
            });
    }
}
</script>
