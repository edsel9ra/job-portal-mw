<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                    <span class="material-symbols-outlined">lock_reset</span>
                </div>

                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Seguridad
                    </p>

                    <h2 class="mt-2 text-xl font-black text-slate-950">
                        Actualizar contraseña
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Asegúrate de usar una contraseña segura para proteger tu cuenta.
                    </p>
                </div>
            </div>
        </div>

        <form @submit.prevent="updatePassword" class="space-y-6 px-6 py-6">
            <div class="grid grid-cols-1 gap-5">
                <div>
                    <InputLabel for="current_password" value="Contraseña actual"
                        class="text-sm font-black text-slate-800" />

                    <div class="relative mt-2">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                        </div>

                        <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                            type="password"
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                            autocomplete="current-password" />
                    </div>

                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <InputLabel for="password" value="Nueva contraseña" class="text-sm font-black text-slate-800" />

                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">key</span>
                            </div>

                            <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                                class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                autocomplete="new-password" />
                        </div>

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirmar contraseña"
                            class="text-sm font-black text-slate-800" />

                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                            </div>

                            <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                                class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                autocomplete="new-password" />
                        </div>

                        <InputError :message="form.errors.password_confirmation" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                <p class="text-sm font-black text-slate-800">
                    Recomendación de seguridad
                </p>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Usa una contraseña diferente a las anteriores y evita compartirla con otras personas.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful"
                        class="rounded-2xl border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                        Guardado.
                    </p>
                </Transition>

                <PrimaryButton :disabled="form.processing"
                    class="!rounded-2xl !bg-red-600 !px-6 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!bg-red-700 disabled:!opacity-60">
                    {{ form.processing ? 'Guardando...' : 'Actualizar contraseña' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>