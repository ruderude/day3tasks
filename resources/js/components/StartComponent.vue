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

        <form>
            <!-- Name input -->
            <div class="form-outline mb-4">
                <input type="text" id="form4Example1" class="form-control" />
                <label class="form-label" for="form4Example1">Name</label>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="email" id="form4Example2" class="form-control" />
                <label class="form-label" for="form4Example2">Email address</label>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
                <textarea class="form-control" id="form4Example3" rows="4"></textarea>
                <label class="form-label" for="form4Example3">Message</label>
            </div>

            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-center mb-4">
                <input
                class="form-check-input me-2"
                type="checkbox"
                value=""
                id="form4Example4"
                checked
                />
                <label class="form-check-label" for="form4Example4">
                Send me a copy of this message
                </label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Send</button>
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
