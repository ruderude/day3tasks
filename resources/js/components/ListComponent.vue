<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List Component</div>

                    <div class="card-body">
                        I'm an List component.
                        {{messege}}
                        <div>
                            <p>
                                Count : <span class="">{{ number }}</span>
                            </p>
                            <button @click="countDown()">−１</button>
                            <button @click="countUp()">＋１</button>
                            <button @click="hello()">hello</button>
                            <input type="button" value="クリックしてください" v-on:click="helloAlert()">
                            <input type="button" value="クリックコンソール" @click="helloAlert()">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "List",
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
        },
        helloAlert: function() {
            alert('Hello Vue!')
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

<style scoped>

</style>
