<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">タスクの履歴</div>
        </v-app-bar>

        <v-container class="container mt-16">

            <v-progress-circular
                class="progress-circular"
                v-show="overlay"
                indeterminate
                color="green"
                :size="50"
            ></v-progress-circular>

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

            <v-dialog v-model="showTaskModal" width=600>
                <v-card>
                    <v-card-title>タスク</v-card-title>

                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <div class="text-h6">{{postTask.title}}</div>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-1">{{postTask.detail}}</div>
                            </v-col>
                            <v-col cols="12">
                                <div @click="changeDone">
                                    <v-icon>{{modalTaskIcon}}</v-icon>
                                    <span>{{modalTaskText}}</span>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card-text>

                    <v-row justify="end">
                        <v-btn class="ma-6" @click="closeModal">閉じる</v-btn>
                    </v-row>
                </v-card>
            </v-dialog>

        </v-container>

        <v-overlay :value="overlay"></v-overlay>

    </v-app>
</template>

<script>
import Vue from 'vue'
import liff from "@line/liff";
import Task from './task/TaskComponent'

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
        modalTaskIcon: function () {
            return this.postTask.done ? 'mdi-cards-heart' : 'mdi-arrow-right-circle'
        },
        modalTaskText: function () {
            return this.postTask.done ? "完了" : "未完了"
        }
    },
    methods: {
        openTaskModal: function(task) {
            this.postTask = task
            this.showTaskModal = true
        },
        closeModal: function() {
            this.showTaskModal = false
            this.postTask = []
        },
        changeDone: function() {
            let task = this.postTask
            axios.post("/oldChangeDone", {
                access_token: this.accessToken,
                id: task.id
            })
                .then(response => {
                    // タスクセット
                    task.done = !!response.data.done
                })
                .catch(err => {
                    // console.log(err);
                    this.text = err
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
                axios.post("/oldTasks?page=" + this.page, {
                        access_token: this.accessToken
                    })
                    .then(response => {
                        // タスクセット
                        const tasks = response.data
                        this.text = tasks
                        this.tasks = tasks
                        this.overlay = false
                        this.page += 1
                    })
                    .catch(err => {
                        this.text = err
                        this.overlay = false
                    });
            })
            .catch(err => {
                this.text = err
                this.overlay = false
            })
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
