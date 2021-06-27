<template>
    <v-app>
        <v-app-bar app dense color="orange darken-1">
            <div class="text-white text-h4 mx-auto">今日の三項目</div>
        </v-app-bar>
        
        <v-main>
            <v-container class="mt-5">
                <v-form>
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <v-row>
                        <v-col v-for="task in tasks" :key="task.id" class="mx-auto tasks" cols="10">
                            <v-text-field
                                v-model="task.title"
                                :label="task.label"
                                outlined
                                color="orange lighten-1"
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col class="mx-auto" cols="10">
                            <v-btn
                                class="float-right"
                                fab
                                dark
                                color="teal accent-3"
                            >
                                <v-icon @click="addForm()" dark>
                                    mdi-plus
                                </v-icon>
                            </v-btn>

                            <v-btn
                                class="float-right mr-3"
                                fab
                                dark
                                color="teal accent-3"
                            >
                                <v-icon @click="removeForm()" dark>
                                    mdi-minus
                                </v-icon>
                            </v-btn>
                        </v-col>
                        

                        <v-col class="mx-auto" cols="12">
                            <v-btn @click="submitForm()" color="text-white orange darken-1" block>
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
    props:  {
        csrf: {
            type: String,
            required: true,
        }
    },
    data () {
        return {
            tasks: [
                {
                    id: 1,
                    label: '今日のやること１',
                    title: '',
                    comment: '',
                },
                {
                    id: 2,
                    label: '今日のやること２',
                    title: '',
                    comment: '',
                },
                {
                    id: 3,
                    label: '今日のやること３',
                    title: '',
                    comment: '',
                },
            ]
        }
    },
    computed: {

    },
    methods: {
        addForm: function () {
            const num = this.tasks.length + 1
            console.log(num)
            this.tasks.push({
                id: num,
                label: '今日のやること' + num,
                title: '',
                comment: '',
            })
            // console.log(this.tasks)
        },
        removeForm: function () {
            const num = this.tasks.length - 1
            this.tasks.splice(num, 1)
            // console.log(this.tasks)
        },
        submitForm: function () {
            // axios.defaults.headers.common = {
            //     'X-Requested-With': 'XMLHttpRequest',
            //     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            // };
            axios.post('/today', this.tasks)
                .then((res) => {
                    console.log(res)
                })
            
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
