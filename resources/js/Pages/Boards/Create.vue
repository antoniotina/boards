<template>
    <app-layout>
        <div class="flex justify-center">
            <div class="flex w-6/12 bg-gray px-4 py-5 mt-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <form @submit.prevent="submit">
                    <label for="name" class="ml-3 mr-2">Name : </label>
                    <input id="name" v-model="form.name" class="rounded-sm px-4 py-1 mt-3 mr-3 focus:outline-none bg-gray-100 " />
                    <button type="submit" class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition'>Add</button>
                </form>
            </div>
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