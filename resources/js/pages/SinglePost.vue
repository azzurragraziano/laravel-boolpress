<template>
    <div class="container">
        <div v-if="post">
            <!-- title -->
            <h1>{{post.title}}</h1>

            <!-- cover -->
            <img class="w-25" v-if="post.cover" :src="post.cover" :alt="post.title">

            <!-- tags -->
            <div v-if="post.tags.length > 0">
                <span v-for="tag in post.tags" :key="tag.id" class="badge bg-info text-dark mr-1">{{tag.name}}</span>
            </div>

            <!-- category -->
            <div v-if="post.category">category: {{post.category.name}}</div>

            <!-- content -->
            <p>{{post.content}}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data() {
        return {
            post: null
        };
    },
    mounted() {
        axios.get(`/api/posts/${this.$route.params.slug}`)
        .then((response)=>{
            if(response.data.success){
                this.post = response.data.results;
            } else {
                this.$router.push({name:'not-found'});
            }
        });
    }
}
</script>