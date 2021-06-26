<template>
    <v-app>
        <v-form>
            <v-container>
                <v-row>
                    <v-col
                    cols="12"
                    >
                    <v-text-field
                        label="Outlined"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>

                    <v-col
                    cols="12"
                    >
                    <v-text-field
                        label="Outlined"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>

                    <v-col
                    cols="12"
                    >
                    <v-text-field
                        label="Outlined"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>

                </v-row>
            </v-container>
        </v-form>
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
