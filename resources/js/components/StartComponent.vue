<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">今日の三項目qqq</div>
        </v-app-bar>
        
        <v-main>
            <v-container class="mt-5">
                <v-form>
                    <v-row>
                        <v-col v-for="task in tasks" :key="task.id" class="mx-auto tasks" cols="10">
                            <v-text-field
                                v-model="task.title"
                                :label="task.label"
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
            <div class="form">
                <div class="control">
                    <input class="input" type="text" placeholder="お名前" v-model="formData.name">
                </div>
                <button class="button is-info is-fullwidth" @click="onSubmit()">送信する</button>
            </div>
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
            tasks: [
                {
                    id: 1,
                    label: '今日のやること１',
                    title: '',
                    comment: '',
                },
                {
                    id: 2,
                    label: '今日のやること２',
                    title: '',
                    comment: '',
                },
                {
                    id: 3,
                    label: '今日のやること３',
                    title: '',
                    comment: '',
                },
            ]
        }
    },
    computed: {

    },
    methods: {
        addForm: function () {
            const num = this.tasks.length + 1
            console.log(num)
            this.tasks.push({
                id: num,
                label: '今日のやること' + num,
                title: '',
                comment: '',
            })
            // console.log(this.tasks)
        },
        removeForm: function () {
            const num = this.tasks.length - 1
            this.tasks.splice(num, 1)
            // console.log(this.tasks)
        },
        submitForm: function () {
            axios.defaults.headers.common = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            axios.post('/today', this.tasks)
                .then((res) => {
                    console.log(res)
                })
            
        },
        onSubmit: function () {
            window.liff
                .sendMessages([
                {
                    type: 'text',
                    text: `お名前：\n${this.formData.name}`
                },
                {
                    type: 'text',
                    text: '送信が完了しました'
                }
                ])
                    .then(() => {
                    window.liff.closeWindow()
                })
                    .catch(e => {
                    window.alert('Error sending message: ' + e)
                })
        },
        liffInit: function (liffId) {
            liff.init({
                liffId: liffId
            })
            .then(() => {
                // start to use LIFF's api
                this.accessToken = liff.getAccessToken();
                axios.post('/v1/liff/getAccessToken', liff.getAccessToken())
                .then((res) => {
                    console.log(res)
                })
                // alert(this.accessToken)
            })
            .catch((err) => {
                // alert(err)
            });
        },
    },
    created: function(){
        // alert(liff)
        // Bugsnag.notify(new Error('Test error'))
    },
    mounted: function(){
        // alert(this.liffId)
        this.liffInit(this.liffId)
        
    }
}
</script>

<style scoped>

</style>
