<template>
    <div class="mt-6">
        <v-data-table
            :headers="headers"
            :items="followers"
            :items-per-page="10"
            class="elevation-1"
        >
            <template v-slot:item.name="{ item }">
                <router-link
                    :to="{ name: 'follower', params: {mid: item.mid } }"
                >{{ item.name }}</router-link>
            </template>
            <template v-slot:item.icon_url="{ item }">
                <router-link :to="{ name: 'follower', params: {mid: item.mid } }">
                    <v-img
                        lazy-src=""
                        max-height="80"
                        max-width="100"
                        :src="item.icon_url"
                    ></v-img>
                </router-link>
            </template>
            <template v-slot:item.blocked_at="{ item }">
                <span v-if="item.blocked_at">ブロック中</span>
                <span v-else>フォロー中</span>
            </template>
        </v-data-table>
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
    name: "AdminHome",

    props: {

    },
    data() {
        return {
            headers: [
                {
                    text: 'フォロワー',
                    align: 'start',
                    sortable: false,
                    value: 'icon_url',
                    width: 200,
                },
                { text: '名前', value: 'name' },
                { text: 'mid', value: 'mid' },
                { text: 'ブロック', value: 'blocked_at' },
                { text: '作成日', value: 'created_at' },
            ],
            followers: [],
        };
    },
    computed: {

    },
    methods: {

    },
    created: function() {
        axios
            .get("/followers")
            .then(response => {
                this.followers = response.data
                console.log(this.followers)
            })
            .catch(err => {
                alert(err)
            });
    },
    mounted: function() {
       
    }
}
</script>