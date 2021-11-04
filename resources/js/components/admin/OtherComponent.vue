<template>
    <v-app>
        <v-container class="mt-16" style="width:80%">
            <h1 class="text-center mt-16">オンラインバー🍸【BarCODE】</h1>
            <br>
            <h3 class="">進行について</h3>
            <p>
            ・後ほど<span class="red--text font-weight-bold">YouTubeに公開予定</span>ですので、顔出し声出しなどは各自の自己責任で判断をお願いします。
            </p>
            <p>
            ・収録後一度動画をチェックいたしますので、「ここはどうしてもカットしてくれ」などは言ってくださると可能範囲で対応いたします。
            <br>連絡は訓志のTwitterのDMに送ってください。（極力そのまま放送したいので対応できかねることもありますのでご了承ください。
            </p>
            <p>
            ・声で会話に参加した方はチャットに<span class="red--text font-weight-bold">「カウンター希望」</span>とお書きください。
            <br>パネリストに変更いたします。<span class="red--text font-weight-bold">（顔出しアリナシはご注意ください）</span>
            </p>
            <p>
            ・便宜上「聞くだけのお客様」をボックスとし、ボックスの方もチャットからどしどしコメントを投げていただいてかまいません。
            <br>ボックスのお客様は顔が映ることはありません。
            </p>
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
    name: "AdminOther",

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