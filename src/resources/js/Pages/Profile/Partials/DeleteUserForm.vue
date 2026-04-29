<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="overflow-hidden rounded-[2rem] border border-red-100 bg-red-50 shadow-sm">
        <div class="border-b border-red-100 bg-white px-6 py-5">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                    <span class="material-symbols-outlined">delete_forever</span>
                </div>

                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Zona de peligro
                    </p>

                    <h2 class="mt-2 text-xl font-black text-slate-950">
                        Eliminar cuenta
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados
                        permanentemente.
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 py-6">
            <div class="rounded-3xl border border-red-200 bg-white p-5">
                <p class="text-sm font-black text-red-700">
                    Esta acción no se puede deshacer
                </p>

                <p class="mt-2 text-sm leading-6 text-red-700/80">
                    Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.
                </p>

                <DangerButton
                    class="mt-5 !rounded-2xl !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!bg-red-700"
                    @click="confirmUserDeletion">
                    Eliminar cuenta
                </DangerButton>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="overflow-hidden rounded-[2rem] bg-white">
                <div
                    class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-6 text-white">
                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-red-600/30 blur-3xl">
                    </div>

                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-200">
                                Confirmación requerida
                            </p>

                            <h2 class="mt-2 text-xl font-black">
                                ¿Estás seguro de eliminar tu cuenta?
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                Esta acción eliminará permanentemente tu cuenta y sus datos asociados.
                            </p>
                        </div>

                        <button type="button"
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white transition hover:bg-white/20"
                            @click="closeModal">
                            ✕
                        </button>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <p class="text-sm leading-6 text-slate-600">
                        Para confirmar, introduce tu contraseña.
                    </p>

                    <div class="mt-5">
                        <InputLabel for="password" value="Contraseña" class="sr-only" />

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">lock</span>
                            </div>

                            <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                                class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                placeholder="Contraseña" @keyup.enter="deleteUser" />
                        </div>

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <SecondaryButton
                            class="!rounded-2xl !border !border-slate-200 !bg-white !px-5 !py-3 !text-sm !font-bold !text-slate-700 hover:!bg-slate-50"
                            @click="closeModal">
                            Cancelar
                        </SecondaryButton>

                        <DangerButton
                            class="!rounded-2xl !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!bg-red-700 disabled:!opacity-60"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteUser">
                            {{ form.processing ? 'Eliminando...' : 'Eliminar cuenta' }}
                        </DangerButton>
                    </div>
                </div>
            </div>
        </Modal>
    </section>
</template>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>