<template>
    <div class="mt-16">
        <h1>
        Test
        </h1>
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
    name: "AdminTest",

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