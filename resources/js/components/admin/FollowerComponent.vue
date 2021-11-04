<template>
    <div class="mt-8 mb-16">
        <h1>
        Follower：{{follower.name}}
        </h1>
        <v-card>
            <v-tabs
            v-model="tab"
            background-color="deep-purple accent-4"
            centered
            dark
            icons-and-text
            >
                <v-tabs-slider></v-tabs-slider>

                <v-tab href="#tab-1">
                    タスク
                    <v-icon>mdi-panda</v-icon>
                </v-tab>

                <v-tab href="#tab-2">
                    メッセージ
                    <v-icon>mdi-content-paste</v-icon>
                </v-tab>

            </v-tabs>

            <v-tabs-items v-model="tab">

                <v-tab-item
                    value="tab-1"
                >
                    <v-card flat>
                        <v-data-table
                            :headers="tasks_headers"
                            :items="follower.tasks"
                            :items-per-page="10"
                            class="elevation-1"
                        >
                        </v-data-table>
                    </v-card>
                </v-tab-item>

                <v-tab-item
                    value="tab-2"
                >
                    <v-card flat>
                        <v-data-table
                            :headers="messages_headers"
                            :items="follower.messages"
                            :items-per-page="10"
                            class="elevation-1"
                        >
                        </v-data-table>
                    </v-card>
                </v-tab-item>

            </v-tabs-items>
        </v-card>
        <br>
    </div>
</template>

<script>
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "AdminFollower",

    data() {
        return {
            follower: null,
            tab: null,
            tasks_headers: [
                {
                    text: 'タスクID',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                    width: 100,
                },
                { text: 'タスク名', value: 'title' },
                { text: 'タスク詳細', value: 'detail' },
                { text: '完了', value: 'done' },
                { text: '作成日', value: 'created_at' },
            ],
            messages_headers: [
                {
                    text: 'メッセージID',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                    width: 100,
                },
                { text: 'タイプ', value: 'type' },
                { text: 'メッセージ', value: 'text' },
                { text: '受信日', value: 'created_at' },
            ],
        };
    },
    computed: {

    },
    methods: {

    },
    created: function() {
        axios
            .get("/follower", {
                params: {
                    mid: this.$route.params.mid
                }
            })
            .then(response => {
                this.follower = response.data
                // console.log(this.follower)
            })
            .catch(err => {
                alert(err)
            });

    },
    mounted: function() {
       
    }
}
</script>