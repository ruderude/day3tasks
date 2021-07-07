<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">今日の三項目</div>
        </v-app-bar>

        <v-main>
            <v-container class="container mt-5">

                <v-progress-circular
                    v-show="overlay"
                    indeterminate
                    color="green"
                    :size="50"
                ></v-progress-circular>

                <v-list v-if="isTasks">
                    <v-list-group
                        v-for="task in tasks"
                        :key="task.id"
                        :prepend-icon="doneIcon(task.done)"
                        color="orange lighten-1"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title
                                    v-text="task.title"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item>
                            <v-list-item-content>
                                <div>
                                    <v-container>
                                        <v-layout wrap>
                                            <v-flex>
                                                <v-btn @click="changeDone(task.id)">
                                                    <v-icon>
                                                        mdi-check-outline
                                                    </v-icon>
                                                </v-btn>
                                            </v-flex>
                                            <v-flex>
                                                <v-btn @click="openEditModal(task)">
                                                    <v-icon>
                                                        mdi-square-edit-outline
                                                    </v-icon>
                                                </v-btn>
                                            </v-flex>
                                            <v-flex>
                                                <v-btn @click="openDeleteModal(task.id)">
                                                    <v-icon>
                                                        mdi-delete
                                                    </v-icon>
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </div>
                                <div class="text-h6">
                                    {{task.title}}
                                </div>
                                <p class="text-justify text-subtitle-1">
                                    {{task.detail}}
                                </p>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </v-list>

                <v-form ref="store_form">
                    <v-row>
                        <v-col
                            v-for="form in forms"
                            :key="form.id"
                            class="mx-auto forms"
                            cols="10"
                        >
                            <v-text-field
                                v-model="form.title"
                                :label="form.label"
                                :name="'new' + form.id"
                                outlined
                                color="orange lighten-1"
                                dense
                                :rules="[limit_length500]"
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
                            <v-btn
                                @click="submitForm()"
                                color="text-white orange darken-1"
                                block
                            >
                                決定!!
                            </v-btn>
                        </v-col>
                        <div class="red--text">{{ error }}</div>
                    </v-row>
                </v-form>

                <v-container class="mt-3">
                    <v-dialog v-model="showEditModal" width=600>
                        <v-card>
                            <v-card-title>タスク編集</v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-sheet class="pa-3">
                                    <v-form ref="edit_form">
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="postTask.title"
                                                    label="タスク"
                                                    name="title"
                                                    :value="postTask.title"
                                                    outlined
                                                    :rules="[required, limit_length500]"
                                                ></v-text-field>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-textarea
                                                    v-model="postTask.detail"
                                                    outlined
                                                    name="detail"
                                                    label="タスク詳細"
                                                    :value="postTask.detail"
                                                    :rules="[limit_length1000]"
                                                ></v-textarea>
                                            </v-col>

                                            <v-col class="mt-n10" cols="12">
                                                <v-checkbox
                                                    v-model="postTask.done"
                                                    label="完了"
                                                    color="success"
                                                    :value="postTask.done"
                                                ></v-checkbox>
                                            </v-col>

                                            <v-col class="mx-auto" cols="12">
                                                <v-btn
                                                    @click="submitEditForm(postTask)"
                                                    color="text-white orange darken-1"
                                                    block
                                                >
                                                    更新
                                                </v-btn>
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

                <v-container class="mt-3">
                    <v-dialog v-model="showDeleteModal" width=600>
                        <v-card>
                            <v-card-title>本当に削除しますか？</v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-sheet class="pa-3">
                                    <v-form>
                                        <v-row>
                                        <v-layout justify-end>
                                            <v-flex shrink>
                                                <v-btn color="error" class="ma-6" @click="submitDeleteForm()">削除する</v-btn>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout justify-end>
                                            <v-flex shrink>
                                                <v-btn class="ma-6" @click="closeModal">キャンセル</v-btn>
                                            </v-flex>
                                        </v-layout>
                                        </v-row>
                                    </v-form>
                                </v-sheet>
                            </v-card-text>
                            
                        </v-card>
                    </v-dialog>
                </v-container>

            </v-container>

            <v-overlay :value="overlay"></v-overlay>
        </v-main>

        <v-footer> </v-footer>
    </v-app>
</template>

<script>
import Vue from "vue";
import Bugsnag from "@bugsnag/js";
import BugsnagPluginVue from "@bugsnag/plugin-vue";
import liff from "@line/liff";
// import ApiHandler from '../lib/api';

import Modal from './ModalComponent'

Bugsnag.start({
    apiKey: "d96162df63a8803bcee425928dcd0f36",
    plugins: [new BugsnagPluginVue()]
});

const bugsnagVue = Bugsnag.getPlugin("vue");
bugsnagVue.installVueErrorHandler(Vue);

// const apiHandler = new ApiHandler()
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "Today",
    components: { Modal },
    props: {
        liffId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            lineId: null,
            accessToken: null,
            forms: [],
            tasks: [],
            isTasks: false,
            error: "",
            overlay: false,
            showEditModal: false,
            showDeleteModal: false,
            postTask: [],
            deleteTaskId: null,
            required: value => !!value || "必ず入力してください",
            limit_length500: value => value.length <=500 || "500文字以内で入力してください",
            limit_length1000: value => value.length <= 1000 || "1000文字以内で入力してください",
        };
    },
    computed: {
        
    },
    methods: {
        doneIcon: function (done) {
            if(done){
                return 'mdi-check'
            } else {
                return 'mdi-arrow-right-circle'
            }
        },
        addForm: function() {
            const num = this.forms.length + 1;
            if (this.isTasks) {
                this.forms.push({
                    id: num,
                    label: "やること追加" + num,
                    title: "",
                    comment: ""
                });
            } else {
                this.forms.push({
                    id: num,
                    label: "今日のやること" + num,
                    title: "",
                    comment: ""
                });
            }
        },
        removeForm: function() {
            const num = this.forms.length - 1;
            this.forms.splice(num, 1);
            // console.log(this.forms)
        },
        submitForm: function() {
            // if (this.$refs.store_form.validate()) {
                // すべてのバリデーションが通過したときのみ
                this.overlay = true
                const data = {
                    forms: this.forms,
                    access_token: this.accessToken
                };

                axios
                    .post("/store", data)
                    .then(response => {
                        const tasks = response.data
                        this.error = response.data;
                        if (tasks.length <= 0 && !this.isTasks) {
                            this.taskInit()
                        } else {
                            this.setTasks(tasks)
                        }
                        this.closeModal()
                    })
                    .catch(err => {
                        this.error = err
                        this.closeModal()
                    });
                
            // } else {
            //     return false
            // }
            
        },
        submitEditForm: function(tasks) {
            if (this.$refs.edit_form.validate()) {
                // すべてのバリデーションが通過したときのみ
                this.overlay = true
                const data = {
                    tasks: tasks,
                    access_token: this.accessToken
                };

                axios
                    .post("/update", data)
                    .then(response => {
                        const tasks = response.data
                        if (tasks.length <= 0 && !this.isTasks) {
                            this.taskInit()
                        } else {
                            this.setTasks(tasks)
                        }
                        this.closeModal()
                    })
                    .catch(err => {
                        this.error = err;
                        this.closeModal()
                    });
                
            } else {
                return false
            }
            
        },
        submitDeleteForm: function() {
            this.overlay = true
            const data = {
                id: this.deleteTaskId,
                access_token: this.accessToken
            };

            axios
                .post("/delete", data)
                .then(response => {
                    const tasks = response.data
                    if (tasks.length <= 0 && !this.isTasks) {
                        this.taskInit()
                    } else {
                        this.setTasks(tasks)
                    }
                    this.closeModal()
                })
                .catch(err => {
                    this.error = err;
                    this.closeModal()
                });
        },
        liffInit: function(liffId) {
            liff.init({
                liffId: liffId
            })
                .then(liff => {
                    // Bugsnag.notify(new Error(liff))
                    this.accessToken = liff.getAccessToken()
                })
                .catch(err => {
                    this.error = err
                });
        },
        taskInit: function() {
            this.forms.splice(-this.forms.length)
            this.forms.push(
                {
                    id: 1,
                    label: "今日のやること１",
                    title: "",
                    comment: ""
                },
                {
                    id: 2,
                    label: "今日のやること２",
                    title: "",
                    comment: ""
                },
                {
                    id: 3,
                    label: "今日のやること３",
                    title: "",
                    comment: ""
                }
            );
        },
        setTasks: function(tasks) {
            this.tasks = tasks;
            this.isTasks = true;
            this.forms.splice(-this.forms.length)
            this.forms.push({
                id: 1,
                label: "やること追加1",
                title: "",
                comment: ""
            });
        },
        openEditModal (task) {
            this.postTask = task
            this.showEditModal = true
        },
        openDeleteModal (id) {
            this.deleteTaskId = id
            this.showDeleteModal = true
        },
        closeModal () {
            this.postTask = []
            this.deleteTaskId = null
            this.showEditModal = false
            this.showDeleteModal = false
            this.overlay = false
        },
        changeDone (id) {
            axios.post("/changeDone", {
                    access_token: this.accessToken,
                    id: id
                })
                .then(response => {
                    // Bugsnag.notify(new Error(response.data))
                    // タスクセット
                    const tasks = response.data
                    if (tasks.length <= 0) {
                        this.taskInit()
                    } else {
                        this.setTasks(tasks)
                    }
                    this.overlay = false
                })
                .catch(err => {
                    // console.log(err);
                    this.error = err
                    this.overlay = false
                    Bugsnag.notify(new Error("/changeDone error"));
                });
        }
    },
    created: function() {
        // alert(liff)
        // Bugsnag.notify(new Error('Test error'))
    },
    mounted: function() {
        this.overlay = true
        liff.init({
            liffId: this.liffId
        })
            .then(() => {
                this.accessToken = liff.getAccessToken()
                // Bugsnag.notify(new Error(this.accessToken))
                axios.post("/setTasks", {
                        access_token: this.accessToken
                    })
                    .then(response => {
                        // Bugsnag.notify(new Error(response.data))
                        // タスクセット
                        const tasks = response.data
                        if (tasks.length <= 0) {
                            this.taskInit()
                        } else {
                            this.setTasks(tasks)
                        }
                        this.overlay = false
                    })
                    .catch(err => {
                        // console.log(err);
                        this.error = err
                        this.overlay = false
                        Bugsnag.notify(new Error("/v1/liff/setTasks error"));
                    });
            })
            .catch(err => {
                this.error = err
                this.overlay = false
                Bugsnag.notify(new Error(err))
            });
    }
};
</script>

<style scoped>
.container {
    position: relative;
}

.v-progress-circular {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    z-index: 100;
}
</style>
