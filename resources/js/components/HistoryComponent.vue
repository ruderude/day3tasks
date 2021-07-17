<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">タスクの履歴</div>
        </v-app-bar>

        <v-main>
            <v-container class="container mt-5">

                <v-progress-circular
                    class="progress-circular"
                    v-show="overlay"
                    indeterminate
                    color="green"
                    :size="50"
                ></v-progress-circular>

<!--                <div>{{text}}</div>-->

                <v-card>
                    <v-list>
                        <div v-for="(dayTasks, key) in tasks" :key="key">
                            <Task
                                @catchTask="openTaskModal"
                                :taskCreatedDay="key"
                                :dayTasks="dayTasks">

                            </Task>
                        </div>
                    </v-list>
                </v-card>

                <v-container class="mt-3">
                    <v-dialog v-model="showTaskModal" width=600>
                        <v-card>
                            <v-card-title>タスク</v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-sheet class="pa-3">
                                    <v-form ref="edit_form">
                                        <v-row>
                                            <v-col cols="12">
                                                <div class="text-h6">{{postTask.title}}</div>
                                            </v-col>
                                            <v-col cols="12">
                                                <div class="text-subtitle-1">{{postTask.detail}}</div>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-icon>{{doneIconRight(postTask.done)}}</v-icon>
                                                <span>{{doneText(postTask.done)}}</span>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-sheet>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-layout justify-end>
                                <v-flex shrink>
                                    <v-btn class="ma-6" @click="closeModal">閉じる</v-btn>
                                </v-flex>
                            </v-layout>

                        </v-card>
                    </v-dialog>
                </v-container>
            </v-container>

            <v-overlay :value="overlay"></v-overlay>
        </v-main>

        <v-footer>
        </v-footer>
    </v-app>
</template>

<script>
import Vue from 'vue'
// import Bugsnag from '@bugsnag/js'
// import BugsnagPluginVue from '@bugsnag/plugin-vue'
import liff from "@line/liff";
import Task from './task/TaskComponent'

// Bugsnag.start({
//     apiKey: 'd96162df63a8803bcee425928dcd0f36',
//     plugins: [new BugsnagPluginVue()]
// })
//
// const bugsnagVue = Bugsnag.getPlugin('vue')
// bugsnagVue.installVueErrorHandler(Vue)

axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "History",
    components: {
        Task,
    },
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
            tasks: {},
            postTask: {},
            showTaskModal: false,
            overlay: false,
            page: 1,
            text: ""
        }
    },
    computed: {

    },
    methods: {
        setTaskDone: function(id) {
            this.tasks = this.tasks.map((dayTask) => {
                return dayTask.filter((value) => {
                    if(value.id === id) {
                        value.done = !value.done
                    }
                })
            })
        },
        openTaskModal: function(task) {
            this.postTask = task
            // this.error = task
            this.showTaskModal = true
        },
        closeModal: function() {
            this.postTask = []
            this.showTaskModal = false
        },
        doneIconRight: function(done) {
            return done ? "mdi-check" : "mdi-arrow-right-circle"
        },
        doneIconLeft: function(done) {
            return done ? "mdi-check" : "mdi-arrow-left-circle"
        },
        doneText: function(done) {
            return done ? "完了" : "未完了"
        },
        parentIcon: function(tasks) {
            const data = true
            return data ? "mdi-arrow-right-circle" : "mdi-cards-heart"
            let result = 0
            for( key in tasks ) {
                // Bugsnag.notify(new Error(tasks[key]))
                if(!tasks[key].done) {
                    result += 1
                }
            }
            return result ? "mdi-arrow-right-circle" : "mdi-cards-heart"
        },
        changeDone: function(task) {
            this.overlay = true
            axios.post("/oldChangeDone", {
                access_token: this.accessToken,
                id: task.id
            })
                .then(response => {
                    // Bugsnag.notify(new Error(response.data))
                    // タスクセット
                    task.done = !!response.data.done
                    // this.text = response.data
                    this.overlay = false
                })
                .catch(err => {
                    // console.log(err);
                    this.text = err
                    this.overlay = false
                    // Bugsnag.notify(new Error("/changeDone error"))
                })
        },
        async getTasks() {
            if (!this.overlay) { //読み込み中は読み込めないようにする
                this.overlay = true
                try {
                    const response = await axios.post('/oldTasks?page=' + this.page, {
                        access_token: this.accessToken
                    })
                    // this.text = response.data
                    const newTasks = response.data
                    Object.assign(this.tasks, newTasks)
                    this.page += 1
                } catch (e) {
                    this.text = e.response
                    this.load = false
                    this.overlay = false
                } finally {
                    this.overlay = false
                }
            }
        },
    },
    created : function(){
        console.log('created')

        },
    mounted: function() {
        window.onscroll = () => {
            let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight == document.documentElement.offsetHeight
            if (bottomOfWindow) this.getTasks()
        }
        this.overlay = true
        liff.init({
            liffId: this.liffId
        })
            .then(() => {
                this.accessToken = liff.getAccessToken()
                // Bugsnag.notify(new Error(this.accessToken))
                axios.post("/oldTasks?page=" + this.page, {
                        access_token: this.accessToken
                    })
                    .then(response => {
                        // Bugsnag.notify(new Error(response.data))
                        // タスクセット
                        const tasks = response.data
                        this.text = tasks
                        this.tasks = tasks
                        this.overlay = false
                        this.page += 1
                    })
                    .catch(err => {
                        // console.log(err);
                        this.text = err
                        this.overlay = false
                        // Bugsnag.notify(new Error("/v1/liff/oldTasks error"))
                    });
            })
            .catch(err => {
                this.text = err
                this.overlay = false
                // Bugsnag.notify(new Error(err))
            })
    },
    filters: {
        truncate: function(value) {
            var length = 12;
            var ommision = "...";
            if (value.length <= length) {
                return value;
            }
            return value.substring(0, length) + ommision;
        }
    },
}
</script>

<style scoped>
.container {
    position: relative;
}

.progress-circular {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    z-index: 100;
}
</style>
