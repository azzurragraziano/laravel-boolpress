<template>
    <div class="container">
        <div v-if="post">
            <!-- title -->
            <h1>{{post.title}}</h1>

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
            this.post = response.data.results;
        });
    }
}
</script>