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
            return this.task.done ? "mdi-check" : "mdi-arrow-left-circle"

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
                    // タスクセット
                    task.done = !!response.data.done
                    // this.text = response.data
                    this.overlay = false
                })
                .catch(err => {
                    // console.log(err);
                    this.text = err
                    this.overlay = false
                })
        },
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

</style>
