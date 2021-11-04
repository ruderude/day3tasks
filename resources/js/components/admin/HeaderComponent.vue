<template>
    <div>
        <!-- Bars/App bars の v-app-bar -->
        <v-app-bar color="primary" dark app clipped-left>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <router-link :to="{ name: 'home'}" class="white--text">
                    Day3tasks
                </router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-title>{{ auth_name }}</v-toolbar-title>
            <div class="pa-2">
                <v-btn block v-on:click="logout">Logout</v-btn>
                <form
                    id="logout-form"
                    action="/logout"
                    method="POST"
                    style="display: none"
                >
                    <input
                        type="hidden"
                        name="_token"
                        :value="csrf_token"
                    />
                </form>
            </div>

        </v-app-bar>

        <!-- 色付きドロワー -->
        <v-navigation-drawer
            app
            v-model="drawer"
            clipped
            class="deep-purple accent-4"
            dark
        >
            <v-list>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    :href="item.to"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block v-on:click="logout">Logout</v-btn>
                    <form
                        id="logout-form"
                        action="/logout"
                        method="POST"
                        style="display: none"
                    >
                        <input
                            type="hidden"
                            name="_token"
                            :value="csrf_token"
                        />
                    </form>
                </div>
            </template>
        </v-navigation-drawer>
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
    name: "AdminHeader",
    props: {
        auth_name: String,
    },
    data() {
        return {
            drawer: null,
            items: [
                { title: "Dashboard", icon: "mdi-view-dashboard", to: "/home" },
                { title: "Oher", icon: "mdi-account-box", to: "/home/other" },
                { title: "Test", icon: "mdi-gavel", to: "/home/test" },
            ],
            csrf_token: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };
    },
    methods: {
        logout() {
            document.getElementById("logout-form").submit();
        },
    },
};
</script>
