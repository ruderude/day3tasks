<template>
    <v-app>
        <v-container class="mt-16" style="width:80%">
            <div class="text-center">
                <a href="/login">
                    <v-btn
                    depressed
                    color="primary"
                    >
                    ログイン
                    </v-btn>
                </a>
            </div>
        </v-container>
        
    </v-app>
</template>

<script>
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "AdminLogin",

    props: {

    },
    data() {
        return {

        };
    },
    computed: {

    },
    methods: {

    },
    created: function() {

    },
    mounted: function() {
       
    }
}
</script>