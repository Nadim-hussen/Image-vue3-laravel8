<template>
    <div>
        <h1>Upload image</h1>
        <p v-if="success.value == true">Successfully inserted</p>
        <form enctype="multipart/form-data" @submit="submit">
            <input type="file" @change="onChange" />
            <button type="submit"> submit</button>
        </form>
    </div>
</template>
<script>
import { ref } from 'vue';
export default {
    setup() {
        const file = ref('')
        const success = ref(false)
        const onChange = (e)=>{
            file.value = e.target.files[0];
        }
        const submit = (e) =>{
            e.preventDefault();
            const config ={
                headers:{
                    'content-type' : 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('file',file.value);
            axios.post('/api/upload',data,config)
            .then((res)=>{
                file.value = '';
                success.value = true;
            }).catch((err)=>{
                console.log(err)
            });
        }
        return{
            submit,
            onChange,
            file,
            success
        }
    },
}
</script>