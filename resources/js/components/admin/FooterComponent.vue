<template>
    <v-footer absolute padless>
        <v-col class="text-center" cols="12">
            {{ new Date().getFullYear() }} — <strong>Day3tasks</strong>
        </v-col>
    </v-footer>
</template>

<script>
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

export default {
    name: "AdminFooter",

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
