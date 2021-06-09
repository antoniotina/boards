<template>
    <app-layout>
        <div class="flex">
            <form @submit.prevent="submit">
                <label for="name">Name:</label>
                <input id="name" v-model="form.name" />
                <button type="submit">Submit</button>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import { computed, reactive } from "vue";
    import AppLayout from '@/Layouts/AppLayout'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from "@inertiajs/inertia-vue3";

    export default {
        setup() {
            const user = computed(() => usePage().props.value.auth.user);

            const form = reactive({
                name: null,
            })

            function submit() {
                Inertia.post('/board/store', form)
            }

            return { user, form, submit };
        },
        components: {
            AppLayout,
        },
    };
</script>