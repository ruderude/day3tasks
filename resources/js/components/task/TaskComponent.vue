<template>
    <v-list-group
        :prepend-icon="dayIcon"
        color="orange lighten-1"
    >
        <template v-slot:activator>
            <v-list-item-content>
                <v-list-item-title v-text="taskCreatedDay"></v-list-item-title>
            </v-list-item-content>
        </template>

        <v-list-item
            v-for="task in dayTasks"
            :key="task.id"
        >
            <v-list-item-content>

                <v-row>
                    <v-col cols="auto" class="text-subtitle-1 mr-auto" @click="openTaskModal(task)">{{ task.title | truncate }}</v-col>
                    <v-col cols="auto">
                        <v-btn small @click="changeDone(task)">
                            <v-icon>
                                {{ doneIconLeft(task.done) }}
                            </v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-list-item-content>
        </v-list-item>

    </v-list-group>
</template>

<script>
import Bugsnag from "@bugsnag/js";

export default {
    name: "TaskComponent.vue",
    props: {
        taskCreatedDay: {
            type: String,
        },
        dayTasks: {
            type: Array,
        },
    },
    data () {
        return {

        }
    },
    computed: {
        dayIcon: function () {
            const tasks = this.dayTasks
            const unDone = tasks.filter(task => task.done === false || task.done === 0)
            // console.log(unDone)
            // console.log(unDone.length ? 'mdi-arrow-right-circle' : 'mdi-cards-heart')
            return unDone.length ? 'mdi-arrow-right-circle' : 'mdi-cards-heart'
        }
    },
    methods: {
        openTaskModal: function(task) {
            this.$emit('catchTask', task);
            // this.postTask = task
            // this.error = task
            // this.showTaskModal = true
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
                    Bugsnag.notify(new Error("/changeDone error"))
                })
        },
        doneIconLeft: function(done) {
            return done ? "mdi-check" : "mdi-arrow-left-circle"
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
}
</script>

<style scoped>

</style>
