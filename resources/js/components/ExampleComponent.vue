<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <button @click="hello()">hello</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
            countUp: function () {
                console.log('hello up')
                // this.number++
            },
            hello: function() {
                console.log('hello hello')
            }
        },
        created : function(){
            console.log('created')
            this.hello()
        },
        mounted : function(){
            console.log('mounted')
            console.log(this.$el)
        }
    }
</script>
