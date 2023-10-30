//Host endpoint
const baseURL = 'https://monolog.kaysolaknigventures.com/public/api/v1/admin/';

//endpoints


const AllRecords = (allName) => {
  if (allName)
    return baseURL + allName
  else
    throw new Error(
      `Please check "${allName}" endpoint, no such endpoint exist`
    );

}
const singleRecord =  (All, Single) => {
  if (Single && All)
    return baseURL + All+'/'+Single
  else
    throw new Error(
      `Please check "${Single}" endpoint, no such endpoint exist`
    );

}


export {
  AllRecords,
  singleRecord
};