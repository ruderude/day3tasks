<template>
    <div>
        <form>
            <!-- Tsak input -->
            <div class="md-form mb-4">
                <input type="text" id="task1" class="form-control" />
                <label class="form-label" for="task1">task1</label>
            </div>

            <div class="md-form mb-4">
                <input type="text" id="task2" class="form-control" />
                <label class="form-label" for="task2">task2</label>
            </div>

            <div class="md-form mb-4">
                <input type="text" id="task3" class="form-control" />
                <label class="form-label" for="task3">task3</label>
            </div>

            <button
                type="button"
                class="btn btn-outline-primary btn-rounded float-right"
                data-mdb-ripple-color="dark"
            >
                タスク追加
            </button>

            <div class="form-outline">
                <input type="text" id="form1" class="form-control" />
                <label class="form-label" for="form1">Example label</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">決定</button>
        </form>
    </div>   
</template>

<script>
export default {
    name: "Start",
    data () {
        return {
            number: 0,
            messege: "はろーー！",
        }
    },
    computed: {

    },
    methods: {
        countDown: function () {
            console.log('hello down')
            // this.number--
        },
    },
    created : function(){
        console.log('created')
    },
    mounted : function(){
        console.log('mounted')
    }
}
</script>

<style scoped>

</style>
