<template>
    <div class="my-8">
        <h1>
        Follower：{{follower.name}}
        </h1>
        <div>
            <v-data-table
                :headers="tasks_headers"
                :items="follower.tasks"
                :items-per-page="10"
                class="elevation-1"
            >
            </v-data-table>
        </div>
        <div class="my-8">
            <v-data-table
                :headers="messages_headers"
                :items="follower.messages"
                :items-per-page="10"
                class="elevation-1"
            >
            </v-data-table>
        </div>
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