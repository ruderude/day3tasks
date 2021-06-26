<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">今日の三項目</div>
        </v-app-bar>
        
        <v-main>
            <v-container>
                <v-form>
                    <v-row>
                        <v-col class="mx-auto" cols="10">
                            <v-text-field
                                label="今日のやること１"
                                outlined
                                color="orange lighten-1"
                                dense 
                            ></v-text-field>
                        </v-col>

                        <v-col class="mx-auto" cols="10">
                            <v-text-field
                                label="今日のやること２"
                                outlined
                                color="orange lighten-1"
                                dense 
                            ></v-text-field>
                        </v-col>

                        <v-col class="mx-auto" cols="10">
                            <v-text-field
                                label="今日のやること３"
                                outlined
                                color="orange lighten-1"
                                dense 
                            ></v-text-field>
                        </v-col>

                        <v-col class="mx-auto" cols="12">
                            <v-btn color="text-white orange darken-1" block>
                                決定!!
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-main>
        
        <v-footer>
        </v-footer>
    </v-app>
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
