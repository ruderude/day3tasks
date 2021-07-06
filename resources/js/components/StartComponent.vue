<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">今日の三項目zzz</div>
        </v-app-bar>
        
        <v-main>
            <v-container class="mt-5">
                <v-list v-if="isTasks" dense>
                    <v-list-group
                        v-for="task in tasks"
                        :key="task.id"
                        :prepend-icon="'mdi-arrow-right-circle'"
                        color="orange lighten-1"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="task.title"></v-list-item-title>
                                <v-list-item-title v-text="task.done"></v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title v-text="task.detail"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </v-list>
                <v-form>
                    <v-row>
                        <v-col v-for="form in forms" :key="form.id" class="mx-auto forms" cols="10">
                            <v-text-field
                                v-model="form.title"
                                :label="form.label"
                                :name="'new' + form.id"
                                outlined
                                color="orange lighten-1"
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col class="mx-auto" cols="10">
                            <v-btn
                                class="float-right"
                                fab
                                dark
                                color="teal accent-3"
                            >
                                <v-icon @click="addForm()" dark>
                                    mdi-plus
                                </v-icon>
                            </v-btn>

                            <v-btn
                                class="float-right mr-3"
                                fab
                                dark
                                color="teal accent-3"
                            >
                                <v-icon @click="removeForm()" dark>
                                    mdi-minus
                                </v-icon>
                            </v-btn>
                        </v-col>
                        

                        <v-col class="mx-auto" cols="12">
                            <v-btn @click="submitForm()" color="text-white orange darken-1" block>
                                決定!
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
            <div id="liff_id">LIFF ID：{{ liffId }}</div>
            <div id="line_id">LINE ID：{{ lineId }}</div>
            <div id="access_token">access_token：{{ accessToken }}</div>
            <ul>
                <li v-for="task in tasks">{{ task.id }}:::{{ task.title }}:::{{ task.done }}</li>
            </ul>
            <div class="form">
                <div class="control">
                    <input class="input" type="text" placeholder="お名前" v-model="formData.name">
                </div>
                <button class="button is-info is-fullwidth" @click="onSubmit()">送信する</button>
            </div>
            <v-btn @click="getAccess()">GET</v-btn>
            <v-btn @click="postAccess()">POST</v-btn>
        </v-main>
        
        <v-footer>
            
        </v-footer>
    </v-app>
</template>

<script>
import Vue from 'vue'
import Bugsnag from '@bugsnag/js'
import BugsnagPluginVue from '@bugsnag/plugin-vue'
import liff from '@line/liff';

Bugsnag.start({
    apiKey: 'd96162df63a8803bcee425928dcd0f36',
    plugins: [new BugsnagPluginVue()]
})

const bugsnagVue = Bugsnag.getPlugin('vue')
bugsnagVue.installVueErrorHandler(Vue)

export default {
    name: "Start",
    props: {
        liffId: {
            type: String,
            required: true,
        }
    },
    data () {
        return {
            formData: {
                name: ''
            },
            lineId: null,
            accessToken: null,
            forms: [
                {
                    id: 1,
                    label: 'やること追加',
                    title: '',
                    comment: '',
                },
                // {
                //     id: 1,
                //     label: '今日のやること１',
                //     title: '',
                //     comment: '',
                // },
                // {
                //     id: 2,
                //     label: '今日のやること２',
                //     title: '',
                //     comment: '',
                // },
                // {
                //     id: 3,
                //     label: '今日のやること３',
                //     title: '',
                //     comment: '',
                // },
            ],
            tasks: [],
            isTasks: false
        }
    },
    computed: {

    },
    methods: {
        addForm: function () {
            const num = this.forms.length + 1
            // console.log(num)
            this.forms.push({
                id: num,
                label: '今日のやること' + num,
                title: '',
                comment: '',
            })
            // console.log(this.forms)
        },
        removeForm: function () {
            const num = this.forms.length - 1
            this.forms.splice(num, 1)
            // console.log(this.forms)
        },
        submitForm: function () {
            const data = {
                forms: this.forms,
                access_token: this.accessToken
            }
            axios.defaults.headers.common = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            axios.post('/today', data)
                .then((res) => {
                    console.log(res)
                })
            
        },
        liffInit: function (liffId) {
            liff.init({
                liffId: liffId
            })
            .then((liff) => {
                Bugsnag.notify(new Error(liff))
                this.accessToken = liff.getAccessToken();
            })
            .catch((err) => {
                // alert(err)
            });
        },
        getAccess: function() {
            console.log('GET')
            axios.get('getUser')
                .then(response => {
                    console.log('送信したテキスト: ' + response.data.message);
                }).catch(error => {
                    console.log(error);
                });

        },
        postAccess: function() {
            console.log('getUser')
            axios.post('getAccessToken', {
                text: 'postテストだよー',
                token: this.accessToken
            })
                .then(response => {
                    console.log('送信したテキスト: ' + response.data.message);
                }).catch(error => {
                    console.log(error);
                });
        }
    },
    created: function(){
        // alert(liff)
        // Bugsnag.notify(new Error('Test error'))

    },
    mounted: function(){
        liff.init({
                liffId: this.liffId
            })
            .then(() => {
                this.accessToken = liff.getAccessToken();
                // Bugsnag.notify(new Error(this.accessToken))
                axios.post('/v1/liff/setTasks', {
                    access_token: this.accessToken
                })
                    .then(response => {
                        // Bugsnag.notify(new Error(response.data))
                        // nullチェックはこれでよいか？
                        if(response.data) {
                            this.tasks = response.data
                            this.isTasks = true
                        }
                    }).catch(error => {
                        console.log(error);
                        Bugsnag.notify(new Error('/v1/liff/setTasks error'))
                    });
            })
            .catch((err) => {
                Bugsnag.notify(new Error(err))
            });
    }
}
</script>

<style scoped>

</style>
