<template>
    <div class="">
        I'm an タスク履歴 component.
        <br>
        <button @click="hello()">hello</button>
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
            hello: function() {
                console.log('hello hello')
            }
        },
        created : function(){
            console.log('created')
        },
        mounted : function(){
            console.log('mounted')
        }
    }
</script>
