// frontend/app/composables/useApi.ts

export const useApi = () => {
  const config = useRuntimeConfig();

  return $fetch.create({
    baseURL: config.public.apiKey as string,

    credentials: "include",

    headers: {
      Accept: "application/json",
    },
  });
};