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
            return unDone.length ? 'mdi-arrow-right-circle' : 'mdi-cards-heart'
        },
    },
    methods: {
        openTaskModal: function(task) {
            this.$emit('catchTask', task);
        },
    },
}
</script>

<style scoped>

</style>
