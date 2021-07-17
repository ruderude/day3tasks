<template>
    <v-list-item>
        <v-list-item-content>
            <v-row>
                <v-col cols="auto" class="text-subtitle-1 mr-auto" @click="openTaskModal(task)">{{ task.title | truncate }}</v-col>
                <v-col cols="auto">
                    <v-btn small @click="changeDone(task)">
                        <v-icon>
                            {{ doneIcon }}
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
import Bugsnag from "@bugsnag/js";

export default {
    name: "ListBtnComponent.vue",
    props: {
        task: {
            type: Object,
        },
    },
    data () {
        return {
            task: this.task,
        }
    },
    computed: {
        doneIcon: function () {
            const done = this.task.done
            return done ? "mdi-check" : "mdi-arrow-left-circle"

        },
    },
    methods: {
        openTaskModal: function(task) {
            this.$emit('catchTask', task);
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
    },

}
</script>

<style scoped>

</style>
