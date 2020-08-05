<?php


namespace App\Service;


use App\Entity\Supplier;
use App\Entity\SupplierProductRoot;
use App\Entity\SupplierProductType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\Root;
use Proxies\__CG__\App\Entity\SupplierProduct;

class SupplierService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Импортирует продукты из excel файла
     *
     * @param string $filePath
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importProducts(string $filePath, int $supplierId)
    {
        // Получаем строки excel файла
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $supplier = $this->em->getRepository(Supplier::class)->find($supplierId);
        foreach ($worksheet->getRowIterator() as $rowNum => $row) {
            if ($rowNum == 1) {
                continue;
            }

            $cellIterator = $row->getCellIterator();

            // Заполняем массив значениями из строки
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }

            // Если пустое имя
            if (empty($cells[0])) continue;

            $product = new SupplierProduct();

            // Записываем значения в товар
            $product->setSupplier($supplier);
            $product->setName($cells[0] ?? 0);

            $root = $this->em->getRepository(SupplierProductRoot::class)->findOneBy(['name' => $cells[1]]);
            $product->setRoot($root ?? 0);

            $product->setContainerSize($cells[2] ?? 0);

            $type = $this->em->getRepository(SupplierProductType::class)->findOneBy(['name' => $cells[3]]);
            $product->setType($type ?? 0);

            $product->setDate(new \DateTime());

            $product->setHeight($cells[4] ?? 0);
            $product->setPrice($cells[5] ?? 0);
            $product->setCountMin($cells[6] ?? 0);
            $product->setCountMax($cells[7] ?? 0);
            $product->setDiameterBarrel($cells[8] ?? 0);
            $product->setDiameterCrown($cells[9] ?? 0);
            $product->setDiameterComa($cells[10] ?? 0);
            $product->setComment($cells[11] ?? 0);

            $this->em->persist($product);

        }
        $this->em->flush();
    }
}