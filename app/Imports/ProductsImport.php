<?php

namespace App\Imports;

use App\Models\product\Product;
use App\Models\product\ProductVariation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Spatie\Image\Image;

class ProductsImport implements ToCollection, WithBatchInserts, WithValidation, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $rows = 0;
    private $records;

    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }


    public function collection(Collection $rows)
    {
        if (isset($this->data['category'])) $category = $this->data['category']; else return false;
        if (isset($this->data['warehouse'])) $warehouse = $this->data['warehouse']; else return false;
        ++$this->rows;

        foreach ($rows as $row) {

            if (count($row) == 13) {
                $product = new  Product([
                    'name' => $row[0],
                    'productcategory_id' => $category,
                    'taxrate' => $row[1],
                    'product_des' => $row[2],
                    'unit' => $row[3],
                    'code_type' => $row[10],
                    'ins' => auth()->user()->ins

                ]);
                $product->save();

                $relate = $product->standard()->create([
                    'warehouse_id' => $warehouse,
                    'code' => $row[4],
                    'price' => $row[5],
                    'purchase_price' => $row[6],
                    'disrate' => $row[7],
                    'qty' => $row[8],
                    'alert' => $row[9],
                    'barcode' => $row[11],
                    'expiry' => $row[12],
                    'ins' => auth()->user()->ins
                ]);
            } elseif (count($row) == 14) {
                $product = new  Product([
                    'name' => $row[0],
                    'productcategory_id' => $category,
                    'taxrate' => $row[1],
                    'product_des' => $row[2],
                    'unit' => $row[3],
                    'code_type' => $row[10],
                    'ins' => auth()->user()->ins

                ]);
                $product->save();


                if ($row[13]) {
                    $url = $row[13];


                    $ext = pathinfo($url, PATHINFO_EXTENSION);

                    if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
                        $img = time().Str::random(6) . '.' . $ext;
                        file_put_contents(storage_path('app/public/img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $img), file_get_contents($url));


                    }
                }

                $relate = $product->standard()->create([
                    'warehouse_id' => $warehouse,
                    'code' => $row[4],
                    'price' => $row[5],
                    'purchase_price' => $row[6],
                    'disrate' => $row[7],
                    'qty' => $row[8],
                    'alert' => $row[9],
                    'barcode' => $row[11],
                    'expiry' => $row[12],
                    'image' => @$img,
                    'ins' => auth()->user()->ins
                ]);

            } else {
                return false;
            }
        }


    }


    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function startRow(): int
    {
        return 2;
    }
}
