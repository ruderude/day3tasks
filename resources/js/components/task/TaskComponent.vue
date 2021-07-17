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

        <div
            v-for="task in dayTasks"
            :key="task.id"
        >
            <ListBtn
                @catchTask="openTaskModal"
                :task="task"
            ></ListBtn>
        </div>

    </v-list-group>
</template>

<script>
import Bugsnag from "@bugsnag/js";
import ListBtn from './ListBtnComponent'

export default {
    name: "TaskComponent.vue",
    components: {
        ListBtn,
    },
    props: {
        taskCreatedDay: {
            type: String,
        },
        dayTasks: {
            type: Object,
        },
    },
    data () {
        return {
            taskCreatedDay: this.taskCreatedDay,
            dayTasks: this.dayTasks,
        }
    },
    computed: {
        dayIcon: function () {
            const tasks = this.dayTasks
            const unDone = tasks.filter(task => task.done === false || task.done === 0)
            // console.log(unDone)
            // console.log(unDone.length ? 'mdi-arrow-right-circle' : 'mdi-cards-heart')
            return unDone.length ? 'mdi-arrow-right-circle' : 'mdi-cards-heart'
        },
        doneIcon: function () {
            const done = this.dayTasks.done
            return done ? "mdi-check" : "mdi-arrow-left-circle"

        },
    },
    methods: {
        openTaskModal: function(task) {
            this.$emit('catchTask', task);
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

    },
    created : function(){

    },
}
</script>

<style scoped>

</style>
